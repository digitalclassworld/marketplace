<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\Order;
use App\Models\Product;
use App\Models\Seller;
use App\Models\Service;
use App\Models\User;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Illuminate\View\View;

class CartController extends Controller
{
    /**
     * Display the dedicated full-page checkout.
     */
    public function checkoutPage(Request $request): View
    {
        $customer = Auth::check() && Auth::user()->isCustomer() ? Auth::user() : null;
        $cart = session()->get('marketplace_cart', []);

        // Sanitize cart items so price is selling price and original_price is MRP
        foreach ($cart as $key => &$item) {
            $p = (float)($item['price'] ?? 0);
            $op = (float)($item['original_price'] ?? 0);
            if ($op > 0 && $p > $op) {
                $item['price'] = $op;
                $item['original_price'] = $p;
            }
        }
        unset($item);
        session()->put('marketplace_cart', $cart);

        // Fetch active available coupons from DB
        $availableCoupons = \App\Models\DiscountCoupon::where('status', 'Active')
            ->where(function ($q) {
                $q->whereNull('valid_until')->orWhere('valid_until', '>=', now()->startOfDay());
            })
            ->latest()
            ->take(6)
            ->get();

        return view('cart.checkout', [
            'customer'         => $customer,
            'cart'             => $cart,
            'cartCount'        => count($cart),
            'cartTotal'        => $this->calculateTotal($cart),
            'availableCoupons' => $availableCoupons,
        ]);
    }

    /**
     * Get current cart data from session or request.
     */
    public function index(Request $request): JsonResponse
    {
        $cart = session()->get('marketplace_cart', []);
        return response()->json([
            'success' => true,
            'items'   => array_values($cart),
            'count'   => count($cart),
            'total'   => $this->calculateTotal($cart),
        ]);
    }

    /**
     * Add item to cart.
     */
    public function add(Request $request)
    {
        if (Auth::check() && !Auth::user()->isCustomer()) {
            if ($request->expectsJson() || $request->ajax()) {
                return response()->json([
                    'success'       => false,
                    'auth_required' => true,
                    'is_logged_in'  => true,
                    'current_role'  => Auth::user()->role,
                    'message'       => 'You are currently logged in as a ' . ucfirst(Auth::user()->role) . '. Please login with your Customer account to add items to cart and place orders.',
                ], 403);
            }
            return redirect()->back()->with('error', 'Please login with your Customer account to add items to cart.');
        }

        // Normalize legacy or alternate form parameter names
        if ($request->has('name') && !$request->has('title')) {
            $request->merge(['title' => $request->input('name')]);
        }
        if ($request->has('image') && !$request->has('thumbnail')) {
            $request->merge(['thumbnail' => $request->input('image')]);
        }

        $validated = $request->validate([
            'id'              => 'required',
            'type'            => 'required|string', // Course, Service, Product
            'title'           => 'required|string|max:255',
            'price'           => 'required|numeric|min:0',
            'thumbnail'       => 'nullable|string',
            'seller_id'       => 'nullable|integer',
            'quantity'        => 'nullable|integer|min:1',
            'coupon_code'     => 'nullable|string|max:50',
            'discount_amount' => 'nullable|numeric|min:0',
            'original_price'  => 'nullable|numeric|min:0',
        ]);

        // Normalize price & original_price: ensure price is selling price and original_price is MRP
        $inPrice = (float) $validated['price'];
        $inOrigPrice = (float) ($validated['original_price'] ?? $inPrice);
        if ($inOrigPrice > 0 && $inPrice > $inOrigPrice) {
            $temp = $inPrice;
            $inPrice = $inOrigPrice;
            $inOrigPrice = $temp;
        }
        $validated['price'] = $inPrice;
        $validated['original_price'] = $inOrigPrice;

        $cart = session()->get('marketplace_cart', []);
        $cartKey = strtolower($validated['type']) . '_' . $validated['id'];

        if (isset($cart[$cartKey])) {
            $cart[$cartKey]['quantity'] += ($validated['quantity'] ?? 1);
            if (!empty($validated['coupon_code'])) {
                $cart[$cartKey]['coupon_code'] = $validated['coupon_code'];
                $cart[$cartKey]['price'] = (float) $validated['price'];
                $cart[$cartKey]['discount_amount'] = (float) ($validated['discount_amount'] ?? 0);
            }
        } else {
            $cart[$cartKey] = [
                'key'             => $cartKey,
                'id'              => $validated['id'],
                'type'            => ucfirst($validated['type']),
                'title'           => $validated['title'],
                'price'           => (float) $validated['price'],
                'original_price'  => (float) ($validated['original_price'] ?? $validated['price']),
                'coupon_code'     => $validated['coupon_code'] ?? null,
                'discount_amount' => (float) ($validated['discount_amount'] ?? 0),
                'thumbnail'       => (!empty($validated['thumbnail'])) ? $validated['thumbnail'] : 'https://images.unsplash.com/photo-1516321318423-f06f85e504b3?w=300&auto=format&fit=crop&q=80',
                'seller_id'       => $validated['seller_id'] ?? 1,
                'quantity'        => $validated['quantity'] ?? 1,
            ];
        }

        session()->put('marketplace_cart', $cart);

        if (!$request->expectsJson() && !$request->ajax()) {
            return redirect()->route('checkout')->with('success', 'Item added to cart!');
        }

        return response()->json([
            'success' => true,
            'message' => 'Item added to cart successfully!',
            'items'   => array_values($cart),
            'count'   => count($cart),
            'total'   => $this->calculateTotal($cart),
        ]);
    }

    /**
     * Update item quantity in cart.
     */
    public function update(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'key'      => 'required|string',
            'quantity' => 'required|integer|min:0',
        ]);

        $cart = session()->get('marketplace_cart', []);

        if (isset($cart[$validated['key']])) {
            if ($validated['quantity'] <= 0) {
                unset($cart[$validated['key']]);
            } else {
                $cart[$validated['key']]['quantity'] = $validated['quantity'];
            }
            session()->put('marketplace_cart', $cart);
        }

        return response()->json([
            'success' => true,
            'items'   => array_values($cart),
            'count'   => count($cart),
            'total'   => $this->calculateTotal($cart),
        ]);
    }

    /**
     * Remove item from cart.
     */
    public function remove(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'key' => 'required|string',
        ]);

        $cart = session()->get('marketplace_cart', []);

        if (isset($cart[$validated['key']])) {
            unset($cart[$validated['key']]);
            session()->put('marketplace_cart', $cart);
        }

        return response()->json([
            'success' => true,
            'message' => 'Item removed from cart',
            'items'   => array_values($cart),
            'count'   => count($cart),
            'total'   => $this->calculateTotal($cart),
        ]);
    }

    /**
     * Clear all items from cart.
     */
    public function clear(Request $request): JsonResponse
    {
        session()->forget('marketplace_cart');

        return response()->json([
            'success' => true,
            'message' => 'Cart cleared',
            'items'   => [],
            'count'   => 0,
            'total'   => 0.00,
        ]);
    }

    /**
     * Process checkout and create real order(s) in database (Requires customer login).
     */
    public function checkout(Request $request): JsonResponse
    {
        if (Auth::check() && !Auth::user()->isCustomer()) {
            return response()->json([
                'success'       => false,
                'auth_required' => true,
                'is_logged_in'  => true,
                'current_role'  => Auth::user()->role,
                'message'       => 'You are currently logged in as a ' . ucfirst(Auth::user()->role) . '. Please login with your Customer account to complete your purchase.',
            ], 403);
        }

        $validated = $request->validate([
            'name'           => 'required|string|max:100',
            'email'          => 'required|email|max:100',
            'phone'          => 'required|string|max:20',
            'city'           => 'nullable|string|max:100',
            'address'        => 'nullable|string|max:255',
            'payment_method' => 'nullable|string|max:50',
            'coupon_code'    => 'nullable|string|max:50',
            'discount'       => 'nullable|numeric|min:0',
            'items'          => 'nullable|array',
        ]);

        if (!Auth::check()) {
            $user = User::whereRaw('LOWER(email) = ?', [strtolower(trim($validated['email']))])->first();
            if (!$user) {
                $user = User::create([
                    'name'              => $validated['name'],
                    'email'             => strtolower(trim($validated['email'])),
                    'phone'             => $validated['phone'],
                    'city'              => $validated['city'] ?? 'Ahmedabad',
                    'role'              => 'customer',
                    'profession'        => 'Learner / Buyer',
                    'password'          => Hash::make(Str::random(16)),
                    'email_verified_at' => now(),
                ]);
            }
            if ($user && $user->isCustomer()) {
                Auth::login($user);
            }
        }

        // Accept items from either JSON payload or session
        $cartItems = $request->input('items');
        if (empty($cartItems)) {
            $cartItems = array_values(session()->get('marketplace_cart', []));
        }

        if (empty($cartItems)) {
            return response()->json([
                'success' => false,
                'message' => 'Your cart is empty. Please add items before checkout.',
            ], 422);
        }

        $createdOrders = [];
        $totalAmount = 0.00;

        DB::beginTransaction();
        try {
            // Find default primary seller to attach orders if seller_id not found
            $defaultSeller = Seller::first();
            $defaultSellerId = $defaultSeller ? $defaultSeller->id : 1;

            $couponDiscount = floatval($validated['discount'] ?? 0);
            $totalCartSubtotal = 0.00;
            foreach ($cartItems as $ci) {
                $totalCartSubtotal += ((float) ($ci['price'] ?? 0.00)) * ((int) ($ci['quantity'] ?? 1));
            }

            foreach ($cartItems as $item) {
                $qty = (int) ($item['quantity'] ?? 1);
                $unitPrice = (float) ($item['price'] ?? 0.00);
                $origPrice = (float) ($item['original_price'] ?? $unitPrice);

                // Sanitize inverted prices if any
                if ($origPrice > 0 && $unitPrice > $origPrice) {
                    $temp = $unitPrice;
                    $unitPrice = $origPrice;
                    $origPrice = $temp;
                }

                $subtotal = $unitPrice * $qty;
                $itemDiscount = floatval($item['discount_amount'] ?? 0);

                if ($couponDiscount > 0 && ($itemDiscount == 0 || $itemDiscount == $couponDiscount)) {
                    if (count($cartItems) === 1 || $totalCartSubtotal == 0) {
                        $allocatedCoupon = $couponDiscount;
                    } else {
                        $allocatedCoupon = round(($subtotal / $totalCartSubtotal) * $couponDiscount, 2);
                    }

                    // If unit price was already discounted before checkout by this coupon amount
                    if ($origPrice > $unitPrice && abs(($origPrice - $unitPrice) * $qty - $allocatedCoupon) < 0.01) {
                        $finalAmount = $subtotal;
                        $itemDiscount = $allocatedCoupon;
                    } else {
                        $itemDiscount = $allocatedCoupon;
                        $finalAmount = max(0, $subtotal - $allocatedCoupon);
                    }
                } else {
                    $itemDiscount = floatval($item['discount_amount'] ?? 0);
                    $finalAmount = max(0, $subtotal - $itemDiscount);
                }

                $totalAmount += $finalAmount;

                $sellerId = !empty($item['seller_id']) ? (int)$item['seller_id'] : $defaultSellerId;
                // Verify seller exists
                if (!Seller::where('id', $sellerId)->exists()) {
                    $sellerId = $defaultSellerId;
                }

                $orderNumber = '#DC' . rand(10000, 99999);
                $couponTag = !empty($item['coupon_code']) ? $item['coupon_code'] : ($validated['coupon_code'] ?? null);
                $subtext = ($item['type'] ?? 'Item') . ' (Qty: ' . $qty . ')' . ($couponTag ? " [Coupon: {$couponTag}]" : '');

                $order = Order::create([
                    'seller_id'       => $sellerId,
                    'order_number'    => $orderNumber,
                    'customer_name'   => $validated['name'],
                    'customer_city'   => $validated['city'] ?: 'Ahmedabad, GJ',
                    'customer_email'  => $validated['email'],
                    'customer_phone'  => $validated['phone'],
                    'customer_avatar' => 'https://ui-avatars.com/api/?name=' . urlencode($validated['name']) . '&background=0066ff&color=fff',
                    'order_type'      => ucfirst($item['type'] ?? 'Course'),
                    'item_title'      => $item['title'] ?? 'Marketplace Item',
                    'item_subtext'    => $subtext,
                    'item_thumbnail'  => $item['thumbnail'] ?? 'https://images.unsplash.com/photo-1516321318423-f06f85e504b3?w=300&auto=format&fit=crop&q=80',
                    'amount'          => $finalAmount,
                    'subtotal'        => $subtotal,
                    'discount'        => $itemDiscount,
                    'status'          => 'confirmed',
                    'placed_at'       => now(),
                    'timeline'        => [
                        [
                            'title' => 'Order Placed',
                            'time'  => now()->format('M d, Y, h:i A'),
                            'desc'  => 'Order placed via Digital Class Online Checkout.',
                        ],
                        [
                            'title' => 'Payment Confirmed',
                            'time'  => now()->format('M d, Y, h:i A'),
                            'desc'  => 'Payment verified (' . ($validated['payment_method'] ?? 'Online') . ').',
                        ],
                    ],
                ]);

                $createdOrders[] = [
                    'order_number' => $orderNumber,
                    'title'        => $item['title'],
                    'amount'       => $subtotal,
                ];
            }

            DB::commit();

            // Clear session cart
            session()->forget('marketplace_cart');

            return response()->json([
                'success'        => true,
                'message'        => 'Congratulations! Your order has been placed successfully.',
                'order_id'       => $createdOrders[0]['order_number'] ?? ('#DC' . rand(10000, 99999)),
                'orders'         => $createdOrders,
                'total_amount'   => number_format($totalAmount, 2),
                'customer_name'  => $validated['name'],
                'customer_email' => $validated['email'],
            ]);

        } catch (Exception $e) {
            DB::rollBack();
            Log::error('Checkout processing error: ' . $e->getMessage(), [
                'trace' => $e->getTraceAsString(),
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Unable to complete checkout at this time. Please try again.',
            ], 500);
        }
    }

    /**
     * Helper to compute total cart amount.
     */
    private function calculateTotal(array $cart): float
    {
        $total = 0.00;
        foreach ($cart as $item) {
            $total += ((float) ($item['price'] ?? 0)) * ((int) ($item['quantity'] ?? 1));
        }
        return $total;
    }
}

