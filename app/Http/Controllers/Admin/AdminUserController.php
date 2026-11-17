<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Review;
use App\Models\Seller;
use App\Models\User;
use App\Models\UserAdminNote;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Schema;
use Illuminate\View\View;
use Symfony\Component\HttpFoundation\StreamedResponse;

class AdminUserController extends Controller
{
    /**
     * Ensure user_admin_notes table exists dynamically.
     */
    public static function ensureNotesTableExists(): void
    {
        if (!Schema::hasTable('user_admin_notes')) {
            Schema::create('user_admin_notes', function (\Illuminate\Database\Schema\Blueprint $table) {
                $table->id();
                $table->unsignedBigInteger('user_id')->index();
                $table->unsignedBigInteger('admin_id')->nullable();
                $table->string('admin_name')->default('Super Admin');
                $table->text('note');
                $table->timestamps();
            });
        }
    }

    /**
     * Display the Users & Members management view matching UI screenshot.
     */
    public function index(Request $request): View
    {
        self::ensureNotesTableExists();

        $tab = $request->input('tab', 'all');
        $search = $request->input('search');
        $userType = $request->input('user_type');
        $status = $request->input('status');
        $location = $request->input('location');

        // Fetch DB users (latest first so newly created testing accounts appear immediately at the top)
        $dbUsers = collect();
        try {
            if (Schema::hasTable('users')) {
                $dbUsers = User::with('seller.businessDetail')->latest('id')->get();
            }
        } catch (\Throwable $e) {
            \Illuminate\Support\Facades\Log::warning('DB error in AdminUserController: ' . $e->getMessage());
        }

        $realUsers = [];
        foreach ($dbUsers as $u) {
            $sellerObj = $u->seller;
            $type = 'Student';

            if ($u->role === 'superadmin') {
                $type = 'Super Admin';
            } elseif ($sellerObj) {
                $accType = strtolower($sellerObj->account_type ?? '');
                if (str_contains($accType, 'institute') || str_contains($accType, 'company')) {
                    $type = 'Institute';
                } elseif (str_contains($accType, 'agency')) {
                    $type = 'Professional';
                } else {
                    $type = 'Seller';
                }
            } elseif ($u->role === 'seller') {
                $type = 'Seller';
            } elseif ($u->role === 'professional') {
                $type = 'Professional';
            } elseif (!empty($u->profession)) {
                $type = $u->profession;
            }

            // 1. DYNAMIC ORDERS FETCHING (From both customer checkouts AND seller sales)
            $customerOrders = collect();
            try {
                if (Schema::hasTable('orders')) {
                    $customerOrders = Order::where(function ($q) use ($u) {
                        $hasCond = false;
                        if (!empty($u->email)) {
                            $q->where('customer_email', $u->email);
                            $hasCond = true;
                        }
                        if (!empty($u->phone)) {
                            if ($hasCond) {
                                $q->orWhere('customer_phone', $u->phone);
                            } else {
                                $q->where('customer_phone', $u->phone);
                                $hasCond = true;
                            }
                        }
                        if (!empty($u->name)) {
                            if ($hasCond) {
                                $q->orWhere('customer_name', $u->name);
                            } else {
                                $q->where('customer_name', $u->name);
                            }
                        }
                    })->latest('placed_at')->latest('id')->get();
                }
            } catch (\Throwable $e) {}

            $sellerOrders = collect();
            if ($sellerObj) {
                try {
                    $sellerOrders = $sellerObj->orders()->latest('placed_at')->latest('id')->get();
                } catch (\Throwable $e) {}
            }

            // Primary orders list to display for this user
            $isSeller = ($u->role === 'seller' || $sellerObj !== null);
            $primaryOrders = $customerOrders->isNotEmpty() ? $customerOrders : ($isSeller ? $sellerOrders : collect());

            $orderCount = $primaryOrders->count();
            $totalAmount = (float) $primaryOrders->where('status', '!=', 'cancelled')->sum('amount');

            if ($customerOrders->isNotEmpty()) {
                $ordersSummary = $orderCount . ' ' . ($orderCount === 1 ? 'Order' : 'Orders');
                $spentSummary  = '₹' . number_format($totalAmount, 2) . ' spent';
            } elseif ($isSeller && $sellerOrders->isNotEmpty()) {
                $ordersSummary = $orderCount . ' ' . ($orderCount === 1 ? 'Sale' : 'Sales');
                $spentSummary  = '₹' . number_format($totalAmount, 2) . ' earned';
            } else {
                $ordersSummary = '0 Orders';
                $spentSummary  = '₹0 spent';
            }

            // Format each order cleanly for frontend JSON serialization
            $formattedOrders = [];
            foreach ($primaryOrders as $ord) {
                $statusStr = ucfirst(strtolower($ord->status ?? 'confirmed'));
                $statusBadge = in_array(strtolower($statusStr), ['completed', 'confirmed', 'delivered', 'active'])
                    ? 'success'
                    : (in_array(strtolower($statusStr), ['cancelled', 'failed', 'rejected']) ? 'danger' : 'warning');

                $formattedOrders[] = [
                    'id'           => $ord->id,
                    'order_number' => $ord->order_number ?: ('#DC-' . str_pad((string)$ord->id, 5, '0', STR_PAD_LEFT)),
                    'type'         => $ord->order_type ?: 'Product',
                    'title'        => $ord->item_title ?: 'Marketplace Order',
                    'thumbnail'    => $ord->item_thumbnail ?: 'https://images.unsplash.com/photo-1516321318423-f06f85e504b3?w=300&auto=format&fit=crop&q=80',
                    'amount'       => '₹' . number_format((float)$ord->amount, 2),
                    'raw_amount'   => (float)$ord->amount,
                    'status'       => $statusStr,
                    'status_badge' => $statusBadge,
                    'date'         => $ord->placed_at ? $ord->placed_at->format('d M Y') : ($ord->created_at ? $ord->created_at->format('d M Y') : now()->format('d M Y')),
                    'time'         => $ord->placed_at ? $ord->placed_at->format('h:i A') : ($ord->created_at ? $ord->created_at->format('h:i A') : ''),
                    'ago'          => $ord->placed_at ? $ord->placed_at->diffForHumans() : ($ord->created_at ? $ord->created_at->diffForHumans() : 'Recently'),
                ];
            }

            // 2. DYNAMIC ACTIVITIES STREAM
            $city = $u->city ?: ($sellerObj?->businessDetail?->city ?: 'Ahmedabad');
            $state = $u->state ?: ($sellerObj?->businessDetail?->state ?: 'Gujarat');

            $activities = [];

            // Account Created Event
            $activities[] = [
                'title'       => 'Account Created',
                'description' => "Joined Digital Class Educational World as {$type} ({$u->email}).",
                'date'        => $u->created_at ? $u->created_at->format('d M Y, h:i A') : now()->format('d M Y, h:i A'),
                'ago'         => $u->created_at ? $u->created_at->diffForHumans() : 'Recently',
                'icon'        => 'fa-solid fa-user-check',
                'color'       => 'text-success',
                'bg'          => 'bg-success-subtle',
            ];

            // Real Order Activities
            foreach ($primaryOrders as $ord) {
                $isBuyer = $customerOrders->isNotEmpty();
                $actionWord = $isBuyer ? 'Placed order' : 'Received sale';
                $activities[] = [
                    'title'       => "{$actionWord} {$ord->order_number}",
                    'description' => "{$ord->item_title} &bull; ₹" . number_format((float)$ord->amount, 2) . " (" . ucfirst($ord->status) . ")",
                    'date'        => $ord->placed_at ? $ord->placed_at->format('d M Y, h:i A') : ($ord->created_at ? $ord->created_at->format('d M Y, h:i A') : now()->format('d M Y, h:i A')),
                    'ago'         => $ord->placed_at ? $ord->placed_at->diffForHumans() : ($ord->created_at ? $ord->created_at->diffForHumans() : 'Recently'),
                    'icon'        => 'fa-solid fa-bag-shopping',
                    'color'       => 'text-primary',
                    'bg'          => 'bg-primary-subtle',
                ];
            }

            // Verification or Session Event
            if ($u->email_verified_at) {
                $activities[] = [
                    'title'       => 'Email Verified',
                    'description' => 'Email address verified for authenticated marketplace access.',
                    'date'        => $u->email_verified_at->format('d M Y, h:i A'),
                    'ago'         => $u->email_verified_at->diffForHumans(),
                    'icon'        => 'fa-solid fa-envelope-circle-check',
                    'color'       => 'text-info',
                    'bg'          => 'bg-info-subtle',
                ];
            }

            $activities[] = [
                'title'       => 'Active Session Recorded',
                'description' => "Connected from {$city}, {$state}.",
                'date'        => $u->updated_at ? $u->updated_at->format('d M Y, h:i A') : now()->format('d M Y, h:i A'),
                'ago'         => $u->updated_at ? $u->updated_at->diffForHumans() : 'Recently',
                'icon'        => 'fa-solid fa-clock-rotate-left',
                'color'       => 'text-secondary',
                'bg'          => 'bg-secondary-subtle',
            ];

            // 3. DYNAMIC REVIEWS FETCHING
            $reviewsList = [];
            try {
                if (Schema::hasTable('reviews')) {
                    $revQuery = Review::query()->where(function ($q) use ($u, $sellerObj) {
                        $q->where('user_id', $u->id);
                        if (!empty($u->email)) {
                            $q->orWhere('user_email', $u->email);
                        }
                        if ($sellerObj) {
                            $q->orWhere('seller_id', $sellerObj->id);
                        }
                    });
                    $dbReviews = $revQuery->latest('created_at')->get();
                    foreach ($dbReviews as $rev) {
                        $reviewsList[] = [
                            'id'         => $rev->id,
                            'rating'     => (float)($rev->rating ?? 5.0),
                            'item_title' => $rev->item_title ?: 'Platform Item',
                            'text'       => $rev->review_text ?: 'Good product.',
                            'status'     => $rev->status ?: 'Approved',
                            'date'       => $rev->created_at ? $rev->created_at->format('d M Y') : now()->format('d M Y'),
                            'ago'        => $rev->created_at ? $rev->created_at->diffForHumans() : 'Recently',
                        ];
                    }
                }
            } catch (\Throwable $e) {}

            // 4. DYNAMIC ADMIN NOTES FETCHING
            $notesList = [];
            try {
                $dbNotes = UserAdminNote::where('user_id', $u->id)->latest('created_at')->get();
                foreach ($dbNotes as $n) {
                    $notesList[] = [
                        'id'         => $n->id,
                        'admin_name' => $n->admin_name ?: 'Super Admin',
                        'note'       => $n->note,
                        'created_at' => $n->created_at ? $n->created_at->format('d M Y, h:i A') : now()->format('d M Y, h:i A'),
                        'ago'        => $n->created_at ? $n->created_at->diffForHumans() : 'Recently',
                    ];
                }
            } catch (\Throwable $e) {}

            $statusStr = 'Active';
            if ($sellerObj && in_array($sellerObj->seller_status, ['Inactive', 'Suspended'])) {
                $statusStr = 'Inactive';
            } elseif ($sellerObj && in_array($sellerObj->seller_status, [Seller::STATUS_PENDING_APPROVAL, 'Pending'])) {
                $statusStr = 'Pending';
            }

            $realUsers[] = [
                'id'             => $u->id,
                'code'           => $sellerObj?->seller_code ?: ('UDC' . str_pad((string)$u->id, 5, '0', STR_PAD_LEFT)),
                'name'           => $u->name,
                'email'          => $u->email,
                'phone'          => $u->phone ?: 'N/A',
                'type'           => $type,
                'location'       => "{$city}, {$state}",
                'city'           => $city,
                'joined_date'    => $u->created_at ? $u->created_at->format('d M Y') : now()->format('d M Y'),
                'joined_ago'     => $u->created_at ? $u->created_at->diffForHumans() : 'Recently',
                'status'         => $statusStr,
                'orders_summary' => $ordersSummary,
                'spent_summary'  => $spentSummary,
                'total_spent'    => $totalAmount,
                'total_orders'   => $orderCount,
                'wishlist_count' => 0,
                'dob'            => '01 Jan 2000',
                'gender'         => 'Unspecified',
                'avatar'         => $u->avatar_url ?: ('https://ui-avatars.com/api/?name=' . urlencode($u->name) . '&background=0066ff&color=fff'),
                'recent_orders'  => array_slice($formattedOrders, 0, 3),
                'all_orders'     => $formattedOrders,
                'activities'     => $activities,
                'reviews'        => $reviewsList,
                'notes'          => $notesList,
                'seller_id'      => $sellerObj?->id,
            ];
        }

        // 100% Real Database Users - No fake/dummy fallback
        $allUsers = collect($realUsers);

        // Apply Tab Filter
        if ($tab === 'students') {
            $allUsers = $allUsers->filter(fn($u) => in_array($u['type'], ['Student', 'Student / Learner']));
        } elseif ($tab === 'professionals') {
            $allUsers = $allUsers->filter(fn($u) => in_array($u['type'], ['Professional', 'Working Professional', 'Working Employee / Professional', 'Business Owner', 'Teacher / Educator', 'Freelancer / Agency', 'Freelancer / Consultant', 'Job Seeker', 'Parent / Guardian']));
        } elseif ($tab === 'institutes') {
            $allUsers = $allUsers->filter(fn($u) => in_array($u['type'], ['Institute', 'Institute Representative', 'Institute / Organization']));
        } elseif ($tab === 'sellers') {
            $allUsers = $allUsers->filter(fn($u) => in_array($u['type'], ['Seller', 'Institute']));
        } elseif ($tab === 'inactive') {
            $allUsers = $allUsers->filter(fn($u) => $u['status'] === 'Inactive');
        }

        // Apply Search Filter
        if (!empty($search)) {
            $q = strtolower($search);
            $allUsers = $allUsers->filter(function ($u) use ($q) {
                return str_contains(strtolower($u['name']), $q)
                    || str_contains(strtolower($u['email']), $q)
                    || str_contains(strtolower($u['phone']), $q)
                    || str_contains(strtolower($u['code']), $q);
            });
        }

        // Apply User Type Filter
        if (!empty($userType) && $userType !== 'All') {
            $allUsers = $allUsers->filter(fn($u) => strtolower($u['type']) === strtolower($userType));
        }

        // Apply Status Filter
        if (!empty($status) && $status !== 'All') {
            $allUsers = $allUsers->filter(fn($u) => strtolower($u['status']) === strtolower($status));
        }

        // Apply Location Filter
        if (!empty($location) && $location !== 'All') {
            $allUsers = $allUsers->filter(fn($u) => str_contains(strtolower($u['location']), strtolower($location)));
        }

        // Live Real Database KPI Statistics
        $totalUsers = User::count();
        $usersThisMonth = User::where('created_at', '>=', now()->startOfMonth())->count();
        $usersGrowth = $totalUsers > 0 ? max(0, round(($usersThisMonth / $totalUsers) * 100)) : 0;

        $studentsCount = User::whereIn('role', ['user', 'student', 'customer'])->count();
        $studentsPct = $totalUsers > 0 ? round(($studentsCount / $totalUsers) * 100) : 0;

        $sellersCount = User::where('role', 'seller')->count();
        $sellersPct = $totalUsers > 0 ? round(($sellersCount / $totalUsers) * 100) : 0;

        $professionalsCount = User::where('role', 'professional')->count();
        $professionalsPct = $totalUsers > 0 ? round(($professionalsCount / $totalUsers) * 100) : 0;

        $institutesCount = 0;
        if (Schema::hasTable('sellers')) {
            $institutesCount = Seller::where(function ($q) {
                $q->where('account_type', 'like', '%Institute%')
                  ->orWhere('account_type', 'like', '%Company%');
            })->count();
        }
        $institutesPct = $totalUsers > 0 ? round(($institutesCount / $totalUsers) * 100) : 0;

        $inactiveCount = 0;
        if (Schema::hasTable('sellers')) {
            $inactiveCount = Seller::whereIn('seller_status', ['Inactive', 'Suspended', 'inactive', 'suspended'])->count();
        }
        $activeCount = max(0, $totalUsers - $inactiveCount);
        $activePct = $totalUsers > 0 ? round(($activeCount / $totalUsers) * 100) : 0;
        $inactivePct = $totalUsers > 0 ? round(($inactiveCount / $totalUsers) * 100) : 0;

        $stats = [
            'total_users'          => number_format($totalUsers),
            'users_growth'         => $usersGrowth . '%',
            'users_sub'            => '+' . number_format($usersThisMonth) . ' this month',

            'students'             => number_format($studentsCount),
            'students_growth'      => $studentsPct . '%',
            'students_sub'         => $studentsPct . '% of total',

            'professionals'        => number_format($professionalsCount),
            'professionals_growth' => $professionalsPct . '%',
            'professionals_sub'    => $professionalsPct . '% of total',

            'institutes'           => number_format($institutesCount),
            'institutes_growth'    => $institutesPct . '%',
            'institutes_sub'       => $institutesPct . '% of total',

            'sellers'              => number_format($sellersCount),
            'sellers_growth'       => $sellersPct . '%',
            'sellers_sub'          => $sellersPct . '% of total',

            'active_users'         => number_format($activeCount),
            'active_growth'        => $activePct . '%',
            'active_sub'           => $activePct . '% active',

            'inactive_users'       => number_format($inactiveCount),
            'inactive_growth'      => $inactivePct . '%',
            'inactive_sub'         => $inactivePct . '% inactive',
        ];

        return view('admin.users.index', [
            'users'          => $allUsers->values(),
            'stats'          => $stats,
            'currentTab'     => $tab,
            'searchQuery'    => $search,
            'selectedType'   => $userType,
            'selectedStatus' => $status,
            'selectedLoc'    => $location,
        ]);
    }

    /**
     * Store admin note for a user dynamically.
     */
    public function storeNote(Request $request, int $id): JsonResponse
    {
        $validated = $request->validate([
            'note' => 'required|string|max:1000',
        ]);

        self::ensureNotesTableExists();

        $adminUser = Auth::user();
        $adminName = $adminUser ? $adminUser->name : 'Super Admin';

        $note = UserAdminNote::create([
            'user_id'    => $id,
            'admin_id'   => $adminUser?->id,
            'admin_name' => $adminName,
            'note'       => $validated['note'],
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Admin note added successfully!',
            'note'    => [
                'id'         => $note->id,
                'admin_name' => $note->admin_name,
                'note'       => $note->note,
                'created_at' => $note->created_at->format('d M Y, h:i A'),
                'ago'        => $note->created_at->diffForHumans(),
            ],
        ]);
    }

    /**
     * Delete an admin note dynamically.
     */
    public function deleteNote(int $id): JsonResponse
    {
        self::ensureNotesTableExists();
        UserAdminNote::where('id', $id)->delete();

        return response()->json([
            'success' => true,
            'message' => 'Admin note deleted successfully.',
        ]);
    }

    /**
     * Store new user from admin with automatic Seller profile generation if role is seller.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name'     => 'required|string|max:255',
            'email'    => 'required|email|unique:users,email',
            'phone'    => 'nullable|string|max:20',
            'role'     => 'required|string|in:user,seller,superadmin',
            'password' => 'required|string|min:6',
        ]);

        $user = User::create([
            'name'              => $validated['name'],
            'email'             => $validated['email'],
            'phone'             => $validated['phone'] ?? null,
            'role'              => $validated['role'],
            'password'          => Hash::make($validated['password']),
            'email_verified_at' => now(),
        ]);

        // Auto-create Seller record & store details if created as Seller
        if ($validated['role'] === 'seller') {
            $seller = Seller::create([
                'user_id'             => $user->id,
                'seller_code'         => 'DC-SELL-' . str_pad((string)$user->id, 6, '0', STR_PAD_LEFT),
                'account_type'        => Seller::ACCOUNT_TYPE_INSTITUTE,
                'seller_status'       => Seller::STATUS_ACTIVE,
                'verification_status' => Seller::VERIFICATION_VERIFIED,
                'registration_date'   => now(),
                'approved_at'         => now(),
                'approved_by'         => \Illuminate\Support\Facades\Auth::id() ?? 1,
            ]);

            \App\Models\SellerBusinessDetail::create([
                'seller_id'     => $seller->id,
                'business_name' => $user->name . "'s Academy",
                'business_email'=> $user->email,
                'business_phone'=> $user->phone,
                'city'          => 'Ahmedabad',
            ]);
        }

        return redirect()->route('admin.users.index')->with('success', 'Member ' . $validated['name'] . ' created successfully' . ($validated['role'] === 'seller' ? ' with verified seller portal permissions.' : '.'));
    }

    /**
     * Export users as CSV.
     */
    public function export(Request $request): StreamedResponse
    {
        $headers = [
            'Content-type'        => 'text/csv',
            'Content-Disposition' => 'attachment; filename=users_export_' . date('Y-m-d') . '.csv',
            'Pragma'              => 'no-cache',
            'Cache-Control'       => 'must-revalidate, post-check=0, pre-check=0',
            'Expires'             => '0',
        ];

        $callback = function () {
            $handle = fopen('php://output', 'w');
            fputcsv($handle, ['ID', 'Name', 'Email', 'Phone', 'Role', 'Status', 'Created At']);

            User::chunk(200, function ($users) use ($handle) {
                foreach ($users as $u) {
                    fputcsv($handle, [
                        $u->id,
                        $u->name,
                        $u->email,
                        $u->phone,
                        $u->role,
                        'Active',
                        $u->created_at->format('Y-m-d H:i:s'),
                    ]);
                }
            });

            fclose($handle);
        };

        return response()->stream($callback, 200, $headers);
    }
}
