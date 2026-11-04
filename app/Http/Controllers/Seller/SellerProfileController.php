<?php

namespace App\Http\Controllers\Seller;

use App\Http\Controllers\Controller;
use App\Http\Requests\SellerProfileUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class SellerProfileController extends Controller
{
    /**
     * Display the seller profile page.
     */
    public function edit(): View
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();
        $seller = $user->seller?->load(['businessDetail', 'user']);

        return view('seller.profile', [
            'seller' => $seller,
            'user'   => $user,
        ]);
    }

    /**
     * Update permitted seller profile information.
     */
    public function update(SellerProfileUpdateRequest $request): RedirectResponse
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();
        $seller = $user->seller;
        $validated = $request->validated();

        DB::beginTransaction();
        try {
            // Handle Avatar Upload
            if ($request->hasFile('avatar')) {
                $file = $request->file('avatar');
                $filename = 'avatar_' . $user->id . '_' . time() . '.' . $file->getClientOriginalExtension();
                $file->move(public_path('uploads/avatars'), $filename);
                $user->avatar = 'uploads/avatars/' . $filename;
            } elseif (!empty($validated['avatar_url'])) {
                $user->avatar = $validated['avatar_url'];
            }

            // Update permitted User fields
            $user->update([
                'name'  => $validated['name'],
                'email' => $validated['email'],
                'phone' => $validated['phone'],
                'avatar'=> $user->avatar,
            ]);

            // Update or create permitted SellerBusinessDetail fields
            $seller->businessDetail()->updateOrCreate(
                ['seller_id' => $seller->id],
                [
                    'business_name'        => $validated['business_name'] ?? $validated['name'],
                    'business_email'       => $validated['business_email'] ?? $validated['email'],
                    'business_phone'       => $validated['business_phone'] ?? $validated['phone'],
                    'website'              => $validated['website'] ?? null,
                    'address'              => $validated['address'] ?? null,
                    'city'                 => $validated['city'] ?? null,
                    'state'                => $validated['state'] ?? null,
                    'pincode'              => $validated['pincode'] ?? null,
                    'business_description' => $validated['business_description'] ?? null,
                ]
            );

            DB::commit();

            return redirect()->route('seller.profile')->with('success', 'Your seller profile has been updated successfully.');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withInput()->with('error', 'Profile update failed. Please try again.');
        }
    }
}

