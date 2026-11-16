<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Seller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Schema;
use Illuminate\View\View;
use Symfony\Component\HttpFoundation\StreamedResponse;

class AdminUserController extends Controller
{
    /**
     * Display the Users & Members management view matching UI screenshot.
     */
    public function index(Request $request): View
    {
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
            }

            $orderCount = $sellerObj ? $sellerObj->orders()->count() : 0;
            $revenueAmount = $sellerObj ? (float) $sellerObj->orders()->where('status', '!=', 'cancelled')->sum('amount') : 0.0;
            $city = $sellerObj?->businessDetail?->city ?: 'Ahmedabad';
            $state = $sellerObj?->businessDetail?->state ?: 'Gujarat';

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
                'orders_summary' => $orderCount > 0 ? "{$orderCount} Orders" : '1 Account',
                'spent_summary'  => $revenueAmount > 0 ? '₹' . number_format($revenueAmount) : '₹0 spent',
                'total_spent'    => $revenueAmount,
                'total_orders'   => $orderCount,
                'wishlist_count' => 0,
                'dob'            => '01 Jan 2000',
                'gender'         => 'Unspecified',
                'avatar'         => $u->avatar_url ?: ('https://ui-avatars.com/api/?name=' . urlencode($u->name) . '&background=0066ff&color=fff'),
                'recent_orders'  => [],
                'seller_id'      => $sellerObj?->id,
            ];
        }

        // 100% Real Database Users - No fake/dummy fallback
        $allUsers = collect($realUsers);

        // Apply Tab Filter
        if ($tab === 'students') {
            $allUsers = $allUsers->filter(fn($u) => $u['type'] === 'Student');
        } elseif ($tab === 'professionals') {
            $allUsers = $allUsers->filter(fn($u) => $u['type'] === 'Professional');
        } elseif ($tab === 'institutes') {
            $allUsers = $allUsers->filter(fn($u) => $u['type'] === 'Institute');
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
        $studentsCount = User::whereIn('role', ['user', 'student'])->count();
        $sellersCount = User::where('role', 'seller')->count();
        $professionalsCount = User::where('role', 'professional')->count();
        $institutesCount = Seller::where(function ($q) {
            $q->where('account_type', 'like', '%Institute%')
              ->orWhere('account_type', 'like', '%Company%');
        })->count();
        $inactiveCount = Seller::whereIn('seller_status', ['Inactive', 'Suspended', 'inactive', 'suspended'])->count();
        $activeCount = max(0, $totalUsers - $inactiveCount);

        $stats = [
            'total_users'     => number_format($totalUsers),
            'students'        => number_format($studentsCount),
            'professionals'   => number_format($professionalsCount),
            'institutes'      => number_format($institutesCount),
            'sellers'         => number_format($sellersCount),
            'active_users'    => number_format($activeCount),
            'inactive_users'  => number_format($inactiveCount),
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

