<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\Order;
use App\Models\Product;
use App\Models\Seller;
use App\Models\Service;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Schema;
use Illuminate\View\View;
use Symfony\Component\HttpFoundation\StreamedResponse;

class AdminOrderController extends Controller
{
    /**
     * Display the Orders & Bookings management console.
     */
    public function index(Request $request): View
    {
        $currentTab = $request->query('tab', 'all');
        $statusFilter = $request->query('status', 'all');
        $typeFilter = $request->query('type', 'all');
        $search = $request->query('search');

        $query = Order::query()->with('seller.businessDetail', 'seller.user')->latest('placed_at')->latest('id');

        // Tab Filter
        if ($currentTab === 'courses') {
            $query->where('order_type', 'Course');
        } elseif ($currentTab === 'services') {
            $query->where('order_type', 'Service');
        } elseif ($currentTab === 'products') {
            $query->where('order_type', 'Product');
        } elseif ($currentTab === 'business') {
            $query->where('order_type', 'Business');
        }

        // Type dropdown
        if ($typeFilter !== 'all') {
            $query->where('order_type', $typeFilter);
        }

        // Status dropdown
        if ($statusFilter !== 'all') {
            $query->where('status', $statusFilter);
        }

        // Search Filter
        if (!empty($search)) {
            $q = $search;
            $query->where(function ($sq) use ($q) {
                $sq->where('order_number', 'like', "%{$q}%")
                   ->orWhere('customer_name', 'like', "%{$q}%")
                   ->orWhere('customer_email', 'like', "%{$q}%")
                   ->orWhere('customer_phone', 'like', "%{$q}%")
                   ->orWhere('item_title', 'like', "%{$q}%");
            });
        }

        $orders = $query->paginate(15)->withQueryString();

        // Calculate real platform-wide order stats
        $totalOrders = Order::count();
        $totalGross = (float) Order::whereNotIn('status', ['cancelled', 'failed', 'refunded'])->sum('amount');
        $pendingCount = Order::whereIn('status', ['confirmed', 'processing', 'in_progress', 'pending'])->count();
        $completedCount = Order::whereIn('status', ['completed', 'delivered', 'paid'])->count();
        $cancelledCount = Order::whereIn('status', ['cancelled', 'failed', 'refunded'])->count();

        $stats = [
            'total_orders'    => $totalOrders,
            'total_gross'     => '₹' . number_format($totalGross, 2),
            'raw_gross'       => $totalGross,
            'pending_count'   => $pendingCount,
            'completed_count' => $completedCount,
            'cancelled_count' => $cancelledCount,
            'count_all'       => $totalOrders,
            'count_courses'   => Order::where('order_type', 'Course')->count(),
            'count_services'  => Order::where('order_type', 'Service')->count(),
            'count_products'  => Order::where('order_type', 'Product')->count(),
            'count_business'  => Order::where('order_type', 'Business')->count(),
        ];

        return view('admin.orders.index', [
            'orders'       => $orders,
            'stats'        => $stats,
            'currentTab'   => $currentTab,
            'statusFilter' => $statusFilter,
            'typeFilter'   => $typeFilter,
            'searchQuery'  => $search,
        ]);
    }

    /**
     * Show single order JSON for drawer / modal.
     */
    public function show(int $id): JsonResponse
    {
        $order = Order::with('seller.businessDetail', 'seller.user')->findOrFail($id);
        return response()->json($order);
    }

    /**
     * Update order status.
     */
    public function updateStatus(Request $request, int $id): JsonResponse|RedirectResponse
    {
        $validated = $request->validate([
            'status' => 'required|string|in:confirmed,processing,completed,delivered,cancelled',
        ]);

        $order = Order::findOrFail($id);
        $oldStatus = $order->status;
        $order->status = $validated['status'];

        $timeline = $order->timeline ?: [];
        $timeline[] = [
            'title' => 'Status Updated to ' . ucfirst($validated['status']),
            'time'  => now()->format('M d, Y, h:i A'),
            'desc'  => 'Status updated by Super Admin from ' . ucfirst($oldStatus) . ' to ' . ucfirst($validated['status']) . '.',
        ];
        $order->timeline = $timeline;
        $order->save();

        if ($request->expectsJson() || $request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => "Order {$order->order_number} status updated to " . ucfirst($validated['status']) . ".",
                'status'  => $order->status,
            ]);
        }

        return redirect()->back()->with('success', "Order {$order->order_number} status updated to " . ucfirst($validated['status']) . ".");
    }

    /**
     * Simulate / Add a real paid test order dynamically for testing revenue & flow.
     */
    public function simulateOrder(Request $request): RedirectResponse
    {
        $seller = Seller::first();
        $sellerId = $seller ? $seller->id : 1;

        $amount = (float) $request->input('amount', 1499.00);
        $orderType = $request->input('type', 'Course');
        $title = $request->input('title', 'Full Stack Web Development & AI Bootcamp');

        $orderNumber = '#DC' . rand(10000, 99999);

        Order::create([
            'seller_id'       => $sellerId,
            'order_number'    => $orderNumber,
            'customer_name'   => 'customer 1',
            'customer_city'   => 'Ahmedabad, Gujarat',
            'customer_email'  => 'customer123@gmail.com',
            'customer_phone'  => '8978451236',
            'customer_avatar' => 'https://ui-avatars.com/api/?name=customer+1&background=0066ff&color=fff',
            'order_type'      => ucfirst($orderType),
            'item_title'      => $title,
            'item_subtext'    => $orderType . ' (Qty: 1)',
            'item_thumbnail'  => 'https://images.unsplash.com/photo-1516321318423-f06f85e504b3?w=300&auto=format&fit=crop&q=80',
            'amount'          => $amount,
            'subtotal'        => $amount,
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
                    'desc'  => 'Payment verified (Online UPI / Net Banking).',
                ],
            ],
        ]);

        return redirect()->route('admin.orders.index')->with('success', "Order {$orderNumber} for ₹" . number_format($amount, 2) . " created successfully!");
    }

    /**
     * Delete an order.
     */
    public function destroy(int $id): RedirectResponse
    {
        $order = Order::findOrFail($id);
        $num = $order->order_number;
        $order->delete();

        return redirect()->back()->with('success', "Order {$num} deleted successfully.");
    }

    /**
     * Export orders to CSV.
     */
    public function export(Request $request): StreamedResponse
    {
        $headers = [
            'Content-type'        => 'text/csv',
            'Content-Disposition' => 'attachment; filename=orders_export_' . date('Y-m-d') . '.csv',
            'Pragma'              => 'no-cache',
            'Cache-Control'       => 'must-revalidate, post-check=0, pre-check=0',
            'Expires'             => '0',
        ];

        $callback = function () {
            $handle = fopen('php://output', 'w');
            fputcsv($handle, ['Order #', 'Date', 'Customer Name', 'Email', 'Phone', 'Type', 'Item Title', 'Amount', 'Status']);

            Order::chunk(200, function ($orders) use ($handle) {
                foreach ($orders as $o) {
                    fputcsv($handle, [
                        $o->order_number,
                        $o->placed_at ? $o->placed_at->format('Y-m-d H:i') : ($o->created_at ? $o->created_at->format('Y-m-d H:i') : ''),
                        $o->customer_name,
                        $o->customer_email,
                        $o->customer_phone,
                        $o->order_type,
                        $o->item_title,
                        $o->amount,
                        $o->status,
                    ]);
                }
            });

            fclose($handle);
        };

        return response()->stream($callback, 200, $headers);
    }
}

