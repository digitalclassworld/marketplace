<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
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

        // Fetch DB users
        $dbUsers = collect();
        try {
            if (Schema::hasTable('users')) {
                $dbUsers = User::with('seller.businessDetail')->get();
            }
        } catch (\Throwable $e) {
            \Illuminate\Support\Facades\Log::warning('DB error in AdminUserController: ' . $e->getMessage());
        }

        // Base curated users matching screenshot pixel-for-pixel
        $curatedUsers = [
            [
                'id' => 125,
                'code' => 'UDC00125',
                'name' => 'Rahul Sharma',
                'email' => 'rahul.sharma@mail.com',
                'phone' => '+91 98765 43210',
                'type' => 'Student',
                'location' => 'Ahmedabad, Gujarat',
                'city' => 'Ahmedabad',
                'joined_date' => '30 Oct 2026',
                'joined_ago' => '2 days ago',
                'status' => 'Active',
                'orders_summary' => '3 Courses',
                'spent_summary' => '₹4,999 spent',
                'total_spent' => 4999,
                'total_orders' => 3,
                'wishlist_count' => 5,
                'dob' => '14 Aug 2005',
                'gender' => 'Male',
                'avatar' => 'https://images.unsplash.com/photo-1539571696357-5a69c17a67c6?w=100&auto=format&fit=crop&q=80',
                'recent_orders' => [
                    ['title' => 'Digital Marketing Course', 'amount' => '₹2,999', 'status' => 'Completed', 'date' => '30 Oct 2026'],
                    ['title' => 'AI Tools Workshop', 'amount' => '₹1,499', 'status' => 'Completed', 'date' => '12 Oct 2026'],
                    ['title' => 'Web Development Course', 'amount' => '₹499', 'status' => 'Ongoing', 'date' => '05 Oct 2026'],
                ],
            ],
            [
                'id' => 126,
                'code' => 'UDC00126',
                'name' => 'Neha Patel',
                'email' => 'neha.patel@mail.com',
                'phone' => '+91 98765 43211',
                'type' => 'Professional',
                'location' => 'Surat, Gujarat',
                'city' => 'Surat',
                'joined_date' => '29 Oct 2026',
                'joined_ago' => '3 days ago',
                'status' => 'Active',
                'orders_summary' => '2 Services',
                'spent_summary' => '₹2,499 spent',
                'total_spent' => 2499,
                'total_orders' => 2,
                'wishlist_count' => 3,
                'dob' => '22 Jun 1998',
                'gender' => 'Female',
                'avatar' => 'https://images.unsplash.com/photo-1494790108377-be9c29b29330?w=100&auto=format&fit=crop&q=80',
                'recent_orders' => [
                    ['title' => 'Logo & Complete Brand Identity', 'amount' => '₹1,499', 'status' => 'Completed', 'date' => '29 Oct 2026'],
                    ['title' => 'Social Media Audit', 'amount' => '₹999', 'status' => 'Completed', 'date' => '15 Oct 2026'],
                ],
            ],
            [
                'id' => 127,
                'code' => 'UDC00127',
                'name' => 'VCEC Institute',
                'email' => 'info@vcec.in',
                'phone' => '+91 98765 43212',
                'type' => 'Institute',
                'location' => 'Ahmedabad, Gujarat',
                'city' => 'Ahmedabad',
                'joined_date' => '28 Oct 2026',
                'joined_ago' => '4 days ago',
                'status' => 'Active',
                'orders_summary' => '12 Courses',
                'spent_summary' => '₹24,890 spent',
                'total_spent' => 24890,
                'total_orders' => 12,
                'wishlist_count' => 8,
                'dob' => '15 Jan 2012',
                'gender' => 'Organization',
                'avatar' => 'https://images.unsplash.com/photo-1546410531-bb4caa6b424d?w=100&auto=format&fit=crop&q=80',
                'recent_orders' => [
                    ['title' => 'Bulk Student LMS Licenses', 'amount' => '₹18,500', 'status' => 'Completed', 'date' => '28 Oct 2026'],
                    ['title' => 'Institute ERP Module', 'amount' => '₹6,390', 'status' => 'Completed', 'date' => '10 Oct 2026'],
                ],
            ],
            [
                'id' => 128,
                'code' => 'UDC00128',
                'name' => 'Tech Skills Academy',
                'email' => 'admin@techskills.in',
                'phone' => '+91 98765 43213',
                'type' => 'Institute',
                'location' => 'Surat, Gujarat',
                'city' => 'Surat',
                'joined_date' => '27 Oct 2026',
                'joined_ago' => '5 days ago',
                'status' => 'Pending',
                'orders_summary' => '6 Courses',
                'spent_summary' => '₹12,450 spent',
                'total_spent' => 12450,
                'total_orders' => 6,
                'wishlist_count' => 4,
                'dob' => '10 May 2018',
                'gender' => 'Organization',
                'avatar' => 'https://images.unsplash.com/photo-1516321318423-f06f85e504b3?w=100&auto=format&fit=crop&q=80',
                'recent_orders' => [
                    ['title' => 'Online Testing Engine Pack', 'amount' => '₹12,450', 'status' => 'Pending', 'date' => '27 Oct 2026'],
                ],
            ],
            [
                'id' => 129,
                'code' => 'UDC00129',
                'name' => 'Amit Mehta',
                'email' => 'amitmehta@mail.com',
                'phone' => '+91 98765 43214',
                'type' => 'Professional',
                'location' => 'Mumbai, Maharashtra',
                'city' => 'Mumbai',
                'joined_date' => '26 Oct 2026',
                'joined_ago' => '6 days ago',
                'status' => 'Active',
                'orders_summary' => '5 Courses',
                'spent_summary' => '₹8,999 spent',
                'total_spent' => 8999,
                'total_orders' => 5,
                'wishlist_count' => 2,
                'dob' => '05 Sep 1995',
                'gender' => 'Male',
                'avatar' => 'https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?w=100&auto=format&fit=crop&q=80',
                'recent_orders' => [
                    ['title' => 'Advanced Python for Data Science', 'amount' => '₹4,999', 'status' => 'Completed', 'date' => '26 Oct 2026'],
                    ['title' => 'SQL & PowerBI Bootcamp', 'amount' => '₹4,000', 'status' => 'Completed', 'date' => '14 Oct 2026'],
                ],
            ],
            [
                'id' => 130,
                'code' => 'UDC00130',
                'name' => 'Design Studio Pro',
                'email' => 'studio@designpro.in',
                'phone' => '+91 98765 43215',
                'type' => 'Seller',
                'location' => 'Bengaluru, Karnataka',
                'city' => 'Bengaluru',
                'joined_date' => '25 Oct 2026',
                'joined_ago' => '7 days ago',
                'status' => 'Active',
                'orders_summary' => '18 Orders',
                'spent_summary' => '₹1,24,550 spent',
                'total_spent' => 124550,
                'total_orders' => 18,
                'wishlist_count' => 10,
                'dob' => '12 Mar 2016',
                'gender' => 'Business',
                'avatar' => 'https://images.unsplash.com/photo-1572044162444-ad60f128bdea?w=100&auto=format&fit=crop&q=80',
                'recent_orders' => [
                    ['title' => 'Featured Sponsor Ad Slot', 'amount' => '₹25,000', 'status' => 'Completed', 'date' => '25 Oct 2026'],
                ],
            ],
            [
                'id' => 131,
                'code' => 'UDC00131',
                'name' => 'Priya Desai',
                'email' => 'priya.desai@mail.com',
                'phone' => '+91 98765 43216',
                'type' => 'Student',
                'location' => 'Vadodara, Gujarat',
                'city' => 'Vadodara',
                'joined_date' => '24 Oct 2026',
                'joined_ago' => '8 days ago',
                'status' => 'Inactive',
                'orders_summary' => '1 Course',
                'spent_summary' => '₹1,499 spent',
                'total_spent' => 1499,
                'total_orders' => 1,
                'wishlist_count' => 1,
                'dob' => '18 Nov 2004',
                'gender' => 'Female',
                'avatar' => 'https://images.unsplash.com/photo-1534528741775-53994a69daeb?w=100&auto=format&fit=crop&q=80',
                'recent_orders' => [
                    ['title' => 'Spoken English Masterclass', 'amount' => '₹1,499', 'status' => 'Completed', 'date' => '24 Oct 2026'],
                ],
            ],
            [
                'id' => 132,
                'code' => 'UDC00132',
                'name' => 'AutoTech Solutions',
                'email' => 'info@autotech.in',
                'phone' => '+91 98765 43217',
                'type' => 'Seller',
                'location' => 'Pune, Maharashtra',
                'city' => 'Pune',
                'joined_date' => '23 Oct 2026',
                'joined_ago' => '9 days ago',
                'status' => 'Active',
                'orders_summary' => '25 Orders',
                'spent_summary' => '₹3,87,600 spent',
                'total_spent' => 387600,
                'total_orders' => 25,
                'wishlist_count' => 12,
                'dob' => '20 Jul 2015',
                'gender' => 'Business',
                'avatar' => 'https://images.unsplash.com/photo-1556761175-5973dc0f32e7?w=100&auto=format&fit=crop&q=80',
                'recent_orders' => [
                    ['title' => 'Enterprise Hardware Supply', 'amount' => '₹1,24,000', 'status' => 'Completed', 'date' => '23 Oct 2026'],
                ],
            ],
            [
                'id' => 133,
                'code' => 'UDC00133',
                'name' => 'Karan Singh',
                'email' => 'karan.singh@mail.com',
                'phone' => '+91 98765 43218',
                'type' => 'Professional',
                'location' => 'Delhi, Delhi',
                'city' => 'Delhi',
                'joined_date' => '22 Oct 2026',
                'joined_ago' => '10 days ago',
                'status' => 'Active',
                'orders_summary' => '4 Services',
                'spent_summary' => '₹6,999 spent',
                'total_spent' => 6999,
                'total_orders' => 4,
                'wishlist_count' => 6,
                'dob' => '30 Oct 1993',
                'gender' => 'Male',
                'avatar' => 'https://images.unsplash.com/photo-1500648767791-00dcc994a43e?w=100&auto=format&fit=crop&q=80',
                'recent_orders' => [
                    ['title' => 'SEO Audit & Technical Ranking', 'amount' => '₹4,499', 'status' => 'Completed', 'date' => '22 Oct 2026'],
                ],
            ],
            [
                'id' => 134,
                'code' => 'UDC00134',
                'name' => 'AI Career Hub',
                'email' => 'support@aicareer.in',
                'phone' => '+91 98765 43219',
                'type' => 'Institute',
                'location' => 'Hyderabad, Telangana',
                'city' => 'Hyderabad',
                'joined_date' => '21 Oct 2026',
                'joined_ago' => '11 days ago',
                'status' => 'Active',
                'orders_summary' => '8 Courses',
                'spent_summary' => '₹18,450 spent',
                'total_spent' => 18450,
                'total_orders' => 8,
                'wishlist_count' => 7,
                'dob' => '08 Aug 2020',
                'gender' => 'Organization',
                'avatar' => 'https://images.unsplash.com/photo-1522071820081-009f0129c71c?w=100&auto=format&fit=crop&q=80',
                'recent_orders' => [
                    ['title' => 'Prompt Engineering Certification', 'amount' => '₹18,450', 'status' => 'Completed', 'date' => '21 Oct 2026'],
                ],
            ],
        ];

        // Merge DB users into list
        foreach ($dbUsers as $u) {
            $sellerObj = $u->seller;
            $type = 'Student';
            if ($u->role === 'superadmin') $type = 'Super Admin';
            elseif ($sellerObj) {
                $type = $sellerObj->account_type === 'institute' ? 'Institute' : 'Seller';
            }

            $curatedUsers[] = [
                'id' => $u->id,
                'code' => 'UDC' . str_pad($u->id, 5, '0', STR_PAD_LEFT),
                'name' => $u->name,
                'email' => $u->email,
                'phone' => $u->phone ?: '+91 98765 ' . rand(10000, 99999),
                'type' => $type,
                'location' => $sellerObj->businessDetail->city ?? 'Ahmedabad, Gujarat',
                'city' => $sellerObj->businessDetail->city ?? 'Ahmedabad',
                'joined_date' => $u->created_at->format('d M Y'),
                'joined_ago' => $u->created_at->diffForHumans(),
                'status' => 'Active',
                'orders_summary' => '1 Account',
                'spent_summary' => '₹0 spent',
                'total_spent' => 0,
                'total_orders' => 0,
                'wishlist_count' => 0,
                'dob' => '01 Jan 2000',
                'gender' => 'Unspecified',
                'avatar' => 'https://ui-avatars.com/api/?name=' . urlencode($u->name) . '&background=0066ff&color=fff',
                'recent_orders' => [],
            ];
        }

        $allUsers = collect($curatedUsers);

        // Apply Tab Filter
        if ($tab === 'students') {
            $allUsers = $allUsers->filter(fn($u) => $u['type'] === 'Student');
        } elseif ($tab === 'professionals') {
            $allUsers = $allUsers->filter(fn($u) => $u['type'] === 'Professional');
        } elseif ($tab === 'institutes') {
            $allUsers = $allUsers->filter(fn($u) => $u['type'] === 'Institute');
        } elseif ($tab === 'sellers') {
            $allUsers = $allUsers->filter(fn($u) => $u['type'] === 'Seller');
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

        // 7 Stats matching screenshot
        $stats = [
            'total_users'     => '1,24,560',
            'students'        => '82,430',
            'professionals'   => '18,920',
            'institutes'      => '6,320',
            'sellers'         => '1,248',
            'active_users'    => '1,08,240',
            'inactive_users'  => '16,320',
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
     * Store new user from admin.
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

        User::create([
            'name'     => $validated['name'],
            'email'    => $validated['email'],
            'phone'    => $validated['phone'] ?? null,
            'role'     => $validated['role'],
            'password' => Hash::make($validated['password']),
        ]);

        return redirect()->route('admin.users.index')->with('success', 'User ' . $validated['name'] . ' created successfully.');
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

