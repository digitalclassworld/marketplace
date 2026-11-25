<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\View\View;

class AdminRoleController extends Controller
{
    /**
     * Display Roles & Permissions matrix and Staff members.
     */
    public function index(): View
    {
        $admins = User::whereIn('role', ['admin', 'superadmin'])->latest()->get();

        $roles = [
            [
                'name'        => 'Super Administrator',
                'slug'        => 'superadmin',
                'description' => 'Unrestricted access to all marketplace modules, financials, CMS, settings, and staff management.',
                'staff_count' => $admins->where('role', 'superadmin')->count() ?: 1,
                'badge'       => 'danger',
                'permissions' => ['Users', 'Sellers', 'Catalog', 'Orders', 'Finance', 'CMS', 'Settings', 'API'],
            ],
            [
                'name'        => 'Operations & Catalog Manager',
                'slug'        => 'catalog_manager',
                'description' => 'Reviews and moderates seller courses, services, coaching institutes, and products.',
                'staff_count' => 2,
                'badge'       => 'primary',
                'permissions' => ['Catalog', 'Reviews', 'Sellers', 'Leads'],
            ],
            [
                'name'        => 'Finance & Accounts Officer',
                'slug'        => 'finance_officer',
                'description' => 'Reviews transaction ledgers, authorizes seller bank payouts, and handles refund claims.',
                'staff_count' => 1,
                'badge'       => 'success',
                'permissions' => ['Orders', 'Finance', 'Payouts', 'Refunds'],
            ],
            [
                'name'        => 'Customer Support Executive',
                'slug'        => 'support_executive',
                'description' => 'Handles live customer chats, support ticket resolutions, and dispute mediation.',
                'staff_count' => 3,
                'badge'       => 'info',
                'permissions' => ['Messages', 'Reviews', 'Leads'],
            ],
        ];

        return view('admin.roles.index', [
            'admins' => $admins,
            'roles'  => $roles,
        ]);
    }

    /**
     * Add a new staff member with an administrative role.
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name'     => 'required|string|max:100',
            'email'    => 'required|email|unique:users,email',
            'role'     => 'required|in:admin,superadmin',
            'password' => 'required|string|min:6',
        ]);

        $user = User::create([
            'name'              => $request->input('name'),
            'email'             => $request->input('email'),
            'role'              => $request->input('role'),
            'password'          => Hash::make($request->input('password')),
            'email_verified_at' => now(),
        ]);

        return redirect()->route('admin.roles.index')->with('success', "Staff account for {$user->name} created successfully with {$user->role} permissions.");
    }

    /**
     * Alias for store.
     */
    public function storeStaff(Request $request): RedirectResponse
    {
        return $this->store($request);
    }
}
