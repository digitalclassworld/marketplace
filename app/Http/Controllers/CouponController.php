<?php

namespace App\Http\Controllers;

use App\Models\DiscountCoupon;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class CouponController extends Controller
{
    /**
     * Validate and calculate discount for a coupon code.
     */
    public function validateCoupon(Request $request): JsonResponse
    {
        $request->validate([
            'code'    => 'required|string|max:50',
            'total'   => 'nullable|numeric|min:0',
            'context' => 'nullable|string|max:50', // e.g. 'business_listing', 'course', 'product', 'all'
        ]);

        $code = strtoupper(trim($request->input('code')));
        $total = floatval($request->input('total', 0));
        $context = strtolower(trim($request->input('context', 'all')));

        // 1. Look up in DiscountCoupon model
        $coupon = DiscountCoupon::where('coupon_code', $code)->first();

        // Fallback to static curated list if not in DB
        $curatedFallback = null;
        if (!$coupon) {
            $curated = [
                'WELCOME10' => [
                    'code'             => 'WELCOME10',
                    'discount_type'    => 'percentage',
                    'discount_value'   => 10.00,
                    'min_order_amount' => 499.00,
                    'applicable_to'    => 'all',
                    'status'           => 'Active',
                    'usage_limit'      => 500,
                    'used_count'       => 78,
                ],
                'FESTIVE500' => [
                    'code'             => 'FESTIVE500',
                    'discount_type'    => 'flat',
                    'discount_value'   => 500.00,
                    'min_order_amount' => 2499.00,
                    'applicable_to'    => 'all',
                    'status'           => 'Active',
                    'usage_limit'      => 200,
                    'used_count'       => 19,
                ],
                'DIGITAL20' => [
                    'code'             => 'DIGITAL20',
                    'discount_type'    => 'percentage',
                    'discount_value'   => 20.00,
                    'min_order_amount' => 1999.00,
                    'applicable_to'    => 'all',
                    'status'           => 'Active',
                    'usage_limit'      => 300,
                    'used_count'       => 42,
                ],
                'DIWALI50' => [
                    'code'             => 'DIWALI50',
                    'discount_type'    => 'percentage',
                    'discount_value'   => 50.00,
                    'min_order_amount' => 1500.00,
                    'applicable_to'    => 'all',
                    'status'           => 'Active',
                    'usage_limit'      => 1000,
                    'used_count'       => 680,
                ],
            ];

            if (isset($curated[$code])) {
                $curatedFallback = (object) $curated[$code];
            }
        }

        $activeCoupon = $coupon ?: $curatedFallback;

        if (!$activeCoupon) {
            return response()->json([
                'success' => false,
                'message' => "Coupon code '{$code}' is invalid or does not exist.",
            ], 422);
        }

        // Check active status
        if (strtolower($activeCoupon->status ?? '') !== 'active') {
            return response()->json([
                'success' => false,
                'message' => "Coupon '{$code}' is currently inactive or has expired.",
            ], 422);
        }

        // Check dates if set on model
        if ($coupon) {
            $now = Carbon::now();
            if ($coupon->valid_from && $coupon->valid_from->isAfter($now)) {
                return response()->json([
                    'success' => false,
                    'message' => "Coupon '{$code}' is scheduled and not active yet.",
                ], 422);
            }
            if ($coupon->valid_until && $coupon->valid_until->endOfDay()->isPast()) {
                return response()->json([
                    'success' => false,
                    'message' => "Coupon '{$code}' has expired.",
                ], 422);
            }
        }

        // Check usage limit
        if (!empty($activeCoupon->usage_limit) && ($activeCoupon->used_count ?? 0) >= $activeCoupon->usage_limit) {
            return response()->json([
                'success' => false,
                'message' => "Coupon '{$code}' has reached its maximum usage limit.",
            ], 422);
        }

        // Check applicable scope
        $applicable = strtolower(trim($activeCoupon->applicable_to ?? 'all'));
        $isApplicable = false;

        if (in_array($applicable, ['all', 'all products', 'all categories', ''])) {
            $isApplicable = true;
        } elseif ($context === 'business_listing' || $context === 'listings') {
            $isApplicable = in_array($applicable, ['business listing', 'business listings', 'business_listing', 'business_listings', 'seller plans', 'all']);
        } elseif ($context === 'course' || $context === 'courses') {
            $isApplicable = in_array($applicable, ['courses', 'course', 'all']);
        } elseif ($context === 'service' || $context === 'services') {
            $isApplicable = in_array($applicable, ['services', 'service', 'all']);
        } elseif ($context === 'product' || $context === 'products') {
            $isApplicable = in_array($applicable, ['products', 'product', 'all']);
        } else {
            $isApplicable = true;
        }

        if (!$isApplicable) {
            return response()->json([
                'success' => false,
                'message' => "Coupon '{$code}' is not applicable for " . ucwords(str_replace('_', ' ', $context)) . " (Applicable on: " . ucwords($applicable) . ").",
            ], 422);
        }

        // Check minimum order amount
        $minAmount = floatval($activeCoupon->min_order_amount ?? 0);
        if ($total > 0 && $total < $minAmount) {
            return response()->json([
                'success' => false,
                'message' => "Minimum order of ₹" . number_format($minAmount, 0) . " required to apply coupon '{$code}'. (Current total: ₹" . number_format($total, 0) . ")",
            ], 422);
        }

        // Calculate discount
        $discountValue = floatval($activeCoupon->discount_value ?? 0);
        $discountType = strtolower($activeCoupon->discount_type ?? 'percentage');
        $discountAmount = 0.00;

        if ($discountType === 'percentage' || $discountType === 'percent') {
            $discountAmount = round(($total * $discountValue) / 100, 2);
        } else {
            $discountAmount = min($total, $discountValue);
        }

        $finalTotal = max(0, round($total - $discountAmount, 2));

        return response()->json([
            'success'          => true,
            'code'             => $code,
            'discount_type'    => $discountType,
            'discount_value'   => $discountValue,
            'discount_amount'  => $discountAmount,
            'min_order_amount' => $minAmount,
            'subtotal'         => $total,
            'total'            => $finalTotal,
            'message'          => "Coupon '{$code}' applied! You saved ₹" . number_format($discountAmount, 2) . " off your order.",
        ]);
    }

    /**
     * Get list of available coupons for display/quick application.
     */
    public function getAvailableCoupons(Request $request): JsonResponse
    {
        $context = strtolower(trim($request->input('context', 'business_listing')));

        $dbCoupons = DiscountCoupon::where('status', 'Active')
            ->where(function ($q) {
                $q->whereNull('valid_until')->orWhere('valid_until', '>=', now()->startOfDay());
            })
            ->get();

        $coupons = [];
        foreach ($dbCoupons as $c) {
            $app = strtolower(trim($c->applicable_to ?: 'all'));
            if ($app === 'all' || str_contains($app, 'business') || $context === 'all') {
                $coupons[] = [
                    'code'             => strtoupper($c->coupon_code),
                    'discount_type'    => $c->discount_type,
                    'discount_value'   => floatval($c->discount_value),
                    'min_order_amount' => floatval($c->min_order_amount),
                    'label'            => ($c->discount_type === 'percentage' ? intval($c->discount_value) . '% OFF' : '₹' . number_format($c->discount_value, 0) . ' OFF') . ' (Min ₹' . number_format($c->min_order_amount, 0) . ')',
                ];
            }
        }

        return response()->json([
            'success' => true,
            'coupons' => $coupons,
        ]);
    }
}

