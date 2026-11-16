<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\Order;
use App\Models\Product;
use App\Models\Seller;
use App\Models\Service;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class CartController extends Controller
{
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
    public function add(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'id'        => 'required',
            'type'      => 'required|string', // Course, Service, Product
            'title'     => 'required|string|max:255',
            'price'     => 'required|numeric|min:0',
            'thumbnail' => 'nullable|string',
            'seller_id' => 'nullable|integer',
            'quantity'  => 'nullable|integer|min:1',
        ]);

        $cart = session()->get('marketplace_cart', []);
        $cartKey = strtolower($validated['type']) . '_' . $validated['id'];

        if (isset($cart[$cartKey])) {
            $cart[$cartKey]['quantity'] += ($validated['quantity'] ?? 1);
        } else {
            $cart[$cartKey] = [
                'key'       => $cartKey,
                'id'        => $validated['id'],
                'type'      => ucfirst($validated['type']),
                'title'     => $validated['title'],
                'price'     => (float) $validated['price'],
                'thumbnail' => $validated['thumbnail'] ?: 'https://images.unsplash.com/photo-1516321318423-f06f85e504b3?w=300&auto=format&fit=crop&q=80',
                'seller_id' => $validated['seller_id'] ?? 1,
                'quantity'  => $validated['quantity'] ?? 1,
            ];
        }

        session()->put('marketplace_cart', $cart);

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
     * Process checkout and create real order(s) in database.
     */
    public function checkout(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'name'           => 'required|string|max:100',
            'email'          => 'required|email|max:100',
            'phone'          => 'required|string|max:20',
            'city'           => 'nullable|string|max:100',
            'address'        => 'nullable|string|max:255',
            'payment_method' => 'nullable|string|max:50',
            'items'          => 'nullable|array',
        ]);

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

            foreach ($cartItems as $item) {
                $qty = (int) ($item['quantity'] ?? 1);
                $unitPrice = (float) ($item['price'] ?? 0.00);
                $subtotal = $unitPrice * $qty;
                $totalAmount += $subtotal;

                $sellerId = !empty($item['seller_id']) ? (int)$item['seller_id'] : $defaultSellerId;
                // Verify seller exists
                if (!Seller::where('id', $sellerId)->exists()) {
                    $sellerId = $defaultSellerId;
                }

                $orderNumber = '#DC' . rand(10000, 99999);

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
                    'item_subtext'    => ($item['type'] ?? 'Item') . ' (Qty: ' . $qty . ')',
                    'item_thumbnail'  => $item['thumbnail'] ?? 'https://images.unsplash.com/photo-1516321318423-f06f85e504b3?w=300&auto=format&fit=crop&q=80',
                    'amount'          => $subtotal,
                    'subtotal'        => $subtotal,
                    'discount'        => 0.00,
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
