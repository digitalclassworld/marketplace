<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Seller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class AdminSellerController extends Controller
{
    /**
     * Display a listing of all sellers with search, status tabs, and filters.
     */
    public function index(Request $request): View
    {
        $status = $request->query('status');
        $search = $request->query('q');
        $accountType = $request->query('type');

        $query = Seller::with(['user', 'businessDetail'])->latest();

        // Status filtering
        if ($status && $status !== 'all') {
            if ($status === 'Pending') {
                $query->whereIn('seller_status', [Seller::STATUS_PENDING_APPROVAL, 'Pending', 'pending']);
            } else {
                $query->where('seller_status', $status);
            }
        }

        // Account type filtering
        if ($accountType && $accountType !== 'all') {
            $query->where('account_type', $accountType);
        }

        // Search query across Seller ID, User Name, User Email, Phone, Business Name
        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('seller_code', 'LIKE', "%{$search}%")
                  ->orWhereHas('user', function ($uq) use ($search) {
                      $uq->where('name', 'LIKE', "%{$search}%")
                         ->orWhere('email', 'LIKE', "%{$search}%")
                         ->orWhere('phone', 'LIKE', "%{$search}%");
                  })
                  ->orWhereHas('businessDetail', function ($bq) use ($search) {
                      $bq->where('business_name', 'LIKE', "%{$search}%")
                         ->orWhere('city', 'LIKE', "%{$search}%")
                         ->orWhere('business_email', 'LIKE', "%{$search}%");
                  });
            });
        }

        $sellers = $query->paginate(12)->withQueryString();

        // Status counts for badge tabs
        $counts = [
            'all'       => Seller::count(),
            'pending'   => Seller::whereIn('seller_status', [Seller::STATUS_PENDING_APPROVAL, 'Pending', 'pending'])->count(),
            'active'    => Seller::whereIn('seller_status', [Seller::STATUS_ACTIVE, 'Active', 'active'])->count(),
            'suspended' => Seller::whereIn('seller_status', [Seller::STATUS_SUSPENDED, 'Suspended', 'suspended'])->count(),
            'rejected'  => Seller::whereIn('seller_status', [Seller::STATUS_REJECTED, 'Rejected', 'rejected'])->count(),
        ];

        return view('admin.sellers.index', [
            'sellers'     => $sellers,
            'counts'      => $counts,
            'status'      => $status,
            'search'      => $search,
            'accountType' => $accountType,
            'isPendingTab'=> false,
        ]);
    }

    /**
     * Dedicated Pending Approvals listing.
     */
    public function pending(Request $request): View
    {
        $search = $request->query('q');

        $query = Seller::with(['user', 'businessDetail'])
            ->whereIn('seller_status', [Seller::STATUS_PENDING_APPROVAL, 'Pending', 'pending'])
            ->latest();

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('seller_code', 'LIKE', "%{$search}%")
                  ->orWhereHas('user', function ($uq) use ($search) {
                      $uq->where('name', 'LIKE', "%{$search}%")
                         ->orWhere('email', 'LIKE', "%{$search}%")
                         ->orWhere('phone', 'LIKE', "%{$search}%");
                  })
                  ->orWhereHas('businessDetail', function ($bq) use ($search) {
                      $bq->where('business_name', 'LIKE', "%{$search}%")
                         ->orWhere('city', 'LIKE', "%{$search}%");
                  });
            });
        }

        $sellers = $query->paginate(12)->withQueryString();

        $counts = [
            'all'       => Seller::count(),
            'pending'   => Seller::whereIn('seller_status', [Seller::STATUS_PENDING_APPROVAL, 'Pending', 'pending'])->count(),
            'active'    => Seller::whereIn('seller_status', [Seller::STATUS_ACTIVE, 'Active', 'active'])->count(),
            'suspended' => Seller::whereIn('seller_status', [Seller::STATUS_SUSPENDED, 'Suspended', 'suspended'])->count(),
            'rejected'  => Seller::whereIn('seller_status', [Seller::STATUS_REJECTED, 'Rejected', 'rejected'])->count(),
        ];

        return view('admin.sellers.index', [
            'sellers'     => $sellers,
            'counts'      => $counts,
            'status'      => 'Pending',
            'search'      => $search,
            'accountType' => null,
            'isPendingTab'=> true,
        ]);
    }

    /**
     * View detailed seller information for auditing and review.
     */
    public function show(int $id): View
    {
        $seller = Seller::with(['user', 'businessDetail', 'approvedBy', 'rejectedBy', 'suspendedBy'])
            ->findOrFail($id);

        return view('admin.sellers.show', [
            'seller' => $seller,
        ]);
    }

    /**
     * Approve a seller account.
     * Transitions seller_status to Active and records audit trail.
     */
    public function approve(Request $request, int $id): RedirectResponse
    {
        $seller = Seller::with('user')->findOrFail($id);

        DB::beginTransaction();
        try {
            $seller->seller_status       = Seller::STATUS_ACTIVE;
            $seller->verification_status = Seller::VERIFICATION_VERIFIED;
            $seller->approved_at         = now();
            $seller->approved_by         = Auth::id();
            // Clear any prior rejection/suspension marks
            $seller->rejection_reason    = null;
            $seller->save();

            DB::commit();

            return redirect()->back()->with('success', "Seller {$seller->seller_code} ({$seller->user->name}) has been approved successfully! Selling and publishing permissions are now unlocked.");
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Failed to approve seller: ' . $e->getMessage());
        }
    }

    /**
     * Reject a seller application.
     */
    public function reject(Request $request, int $id): RedirectResponse
    {
        $seller = Seller::with('user')->findOrFail($id);

        $request->validate([
            'reason' => ['nullable', 'string', 'max:1000'],
        ]);

        DB::beginTransaction();
        try {
            $seller->seller_status       = Seller::STATUS_REJECTED;
            $seller->verification_status = Seller::VERIFICATION_FAILED;
            $seller->rejected_at         = now();
            $seller->rejected_by         = Auth::id();
            $seller->rejection_reason    = $request->input('reason', 'Application did not meet marketplace verification requirements.');
            $seller->save();

            DB::commit();

            return redirect()->back()->with('warning', "Seller {$seller->seller_code} ({$seller->user->name}) has been rejected. Selling access is restricted.");
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Failed to reject seller: ' . $e->getMessage());
        }
    }

    /**
     * Suspend an active seller.
     */
    public function suspend(Request $request, int $id): RedirectResponse
    {
        $seller = Seller::with('user')->findOrFail($id);

        $request->validate([
            'reason' => ['nullable', 'string', 'max:1000'],
        ]);

        DB::beginTransaction();
        try {
            $seller->seller_status    = Seller::STATUS_SUSPENDED;
            $seller->suspended_at     = now();
            $seller->suspended_by     = Auth::id();
            $seller->rejection_reason = $request->input('reason', 'Account suspended by Super Admin due to compliance review.');
            $seller->save();

            DB::commit();

            return redirect()->back()->with('warning', "Seller {$seller->seller_code} ({$seller->user->name}) has been suspended. Selling functionality has been blocked.");
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Failed to suspend seller: ' . $e->getMessage());
        }
    }

    /**
     * Reactivate a suspended or rejected seller.
     */
    public function reactivate(Request $request, int $id): RedirectResponse
    {
        $seller = Seller::with('user')->findOrFail($id);

        DB::beginTransaction();
        try {
            $seller->seller_status       = Seller::STATUS_ACTIVE;
            $seller->verification_status = Seller::VERIFICATION_VERIFIED;
            $seller->approved_at         = now();
            $seller->approved_by         = Auth::id();
            $seller->rejection_reason    = null;
            $seller->save();

            DB::commit();

            return redirect()->back()->with('success', "Seller {$seller->seller_code} ({$seller->user->name}) has been reactivated successfully!");
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Failed to reactivate seller: ' . $e->getMessage());
        }
    }
}

