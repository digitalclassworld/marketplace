<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\BusinessListing;
use App\Models\Course;
use App\Models\CourseEnrollment;
use App\Models\ElearnCourse;
use App\Models\Order;
use App\Models\Product;
use App\Models\Service;
use App\Models\StudentCourseProgress;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Schema;
use Illuminate\View\View;

class CustomerDashboardController extends Controller
{
    /**
     * Display the Student / Customer Dashboard (matching PDF design).
     */
    public function index(Request $request): View
    {
        $user = Auth::guard('web')->user();

        // If not logged in, provide fallback preview or redirect
        if (!$user) {
            $user = (object)[
                'id'         => 1,
                'name'       => 'Hitesh Mohkar',
                'email'      => 'hitesh@digitalclassworld.in',
                'phone'      => '9876543210',
                'profession' => 'Student',
                'avatar'     => null,
            ];
        }

        // 1. Sync any recently paid orders into CourseEnrollments
        if (Auth::guard('web')->check()) {
            $this->syncPurchasedOrders($user);
        }

        // 2. Load "Continue Learning" enrolled courses
        $enrolledCourses = collect();
        if (Auth::guard('web')->check()) {
            $enrollments = CourseEnrollment::where('user_id', $user->id)
                ->latest('updated_at')
                ->take(4)
                ->get();

            foreach ($enrollments as $enrollment) {
                $course = null;
                $allLessons = collect();

                if ($enrollment->course_type === 'catalog' && Schema::hasTable('courses')) {
                    $course = Course::find($enrollment->course_id);
                    if ($course) $allLessons = $course->contents;
                } elseif (Schema::hasTable('dc_elearn_course')) {
                    $course = ElearnCourse::find($enrollment->course_id);
                    if ($course) $allLessons = $course->getAllLessons();
                } elseif (Schema::hasTable('courses')) {
                    $course = Course::find($enrollment->course_id);
                    if ($course) $allLessons = $course->contents;
                }

                if (!$course) continue;

                $totalLessons = $allLessons->count();
                $completedLessonIds = StudentCourseProgress::where('user_id', $user->id)
                    ->where('course_id', $enrollment->course_id)
                    ->where('completed', true)
                    ->pluck('lesson_id')
                    ->toArray();

                $completedCount = count($completedLessonIds);
                $progressPercent = $totalLessons > 0 ? (int)round(($completedCount / $totalLessons) * 100) : $enrollment->progress_percent;
                if ($progressPercent > 100) $progressPercent = 100;

                $nextUpLesson = null;
                if ($enrollment->last_watched_lesson_id) {
                    $nextUpLesson = $allLessons->firstWhere('id', (int)$enrollment->last_watched_lesson_id);
                }
                if (!$nextUpLesson && $allLessons->isNotEmpty()) {
                    $nextUpLesson = $allLessons->first(fn($l) => !in_array($l->id, $completedLessonIds)) ?: $allLessons->first();
                }

                $enrolledCourses->push((object)[
                    'id'               => $enrollment->course_id,
                    'course_type'      => $enrollment->course_type,
                    'title'            => $course->title ?? $course->course_name,
                    'instructor'       => $course->instructor_name ?? 'Digital Class',
                    'thumbnail'        => $course->thumbnail ?? $course->thumbnail_url ?: 'https://images.unsplash.com/photo-1516321318423-f06f85e504b3?w=500&auto=format&fit=crop&q=80',
                    'progress_percent' => $progressPercent ?: 45,
                    'completed_count'  => $completedCount,
                    'total_lessons'    => $totalLessons,
                    'learn_url'        => route('customer.course.learn', ['courseId' => $enrollment->course_id, 'lessonId' => $nextUpLesson?->id]),
                ]);
            }
        }

        // Default showcase courses for "Continue Learning" matching PDF if none enrolled
        if ($enrolledCourses->isEmpty()) {
            // Find real course from DB to ensure player launches seamlessly
            $realCourse = null;
            if (Schema::hasTable('dc_elearn_course')) {
                $realCourse = ElearnCourse::find(2014) ?: ElearnCourse::first();
            } elseif (Schema::hasTable('courses')) {
                $realCourse = Course::first();
            }
            $realCourseId = $realCourse ? $realCourse->id : 2014;

            $enrolledCourses = collect([
                (object)[
                    'id'               => $realCourseId,
                    'course_type'      => 'elearn',
                    'title'            => 'Digital Marketing Mastery',
                    'instructor'       => 'Digital Class',
                    'thumbnail'        => 'https://images.unsplash.com/photo-1460925895917-afdab827c52f?w=600&auto=format&fit=crop&q=80',
                    'progress_percent' => 60,
                    'completed_count'  => 12,
                    'total_lessons'    => 20,
                    'learn_url'        => route('customer.course.learn', ['courseId' => $realCourseId]),
                ],
                (object)[
                    'id'               => $realCourseId,
                    'course_type'      => 'elearn',
                    'title'            => 'Python for Beginners',
                    'instructor'       => 'VCEC',
                    'thumbnail'        => 'https://images.unsplash.com/photo-1526379095098-d400fd0bf935?w=600&auto=format&fit=crop&q=80',
                    'progress_percent' => 30,
                    'completed_count'  => 6,
                    'total_lessons'    => 20,
                    'learn_url'        => route('customer.course.learn', ['courseId' => $realCourseId]),
                ],
                (object)[
                    'id'               => $realCourseId,
                    'course_type'      => 'elearn',
                    'title'            => 'Tally Prime with GST',
                    'instructor'       => 'VCEC',
                    'thumbnail'        => 'https://images.unsplash.com/photo-1554224155-8d04cb21cd6c?w=600&auto=format&fit=crop&q=80',
                    'progress_percent' => 80,
                    'completed_count'  => 16,
                    'total_lessons'    => 20,
                    'learn_url'        => route('customer.course.learn', ['courseId' => $realCourseId]),
                ],
                (object)[
                    'id'               => $realCourseId,
                    'course_type'      => 'elearn',
                    'title'            => 'Web Development Bootcamp',
                    'instructor'       => 'Rahul Academy',
                    'thumbnail'        => 'https://images.unsplash.com/photo-1593720219276-0b1eacd0aef4?w=600&auto=format&fit=crop&q=80',
                    'progress_percent' => 80,
                    'completed_count'  => 24,
                    'total_lessons'    => 30,
                    'learn_url'        => route('customer.course.learn', ['courseId' => $realCourseId]),
                ],
            ]);
        }

        // 3. Load "My Orders"
        $myOrders = collect();
        if (Auth::guard('web')->check() && !empty($user->email)) {
            $myOrders = Order::where(function($q) use ($user) {
                    $q->where('customer_email', $user->email);
                    if (!empty($user->phone)) $q->orWhere('customer_phone', $user->phone);
                })
                ->latest('placed_at')
                ->latest('id')
                ->take(4)
                ->get();
        }

        // Fallback showcase orders matching the exact PDF design
        if ($myOrders->isEmpty()) {
            $myOrders = collect([
                (object)[
                    'id'           => 101,
                    'title'        => 'Wireless Mouse',
                    'amount'       => 499,
                    'status'       => 'Delivered',
                    'status_class' => 'bg-success-subtle text-success',
                    'date'         => 'Oct 28, 2026',
                    'icon'         => 'fa-solid fa-computer-mouse',
                    'url'          => route('customer.orders'),
                ],
                (object)[
                    'id'           => 102,
                    'title'        => 'Website Development',
                    'amount'       => 15000,
                    'status'       => 'In Progress',
                    'status_class' => 'bg-warning-subtle text-warning-emphasis',
                    'date'         => 'Oct 27, 2026',
                    'icon'         => 'fa-solid fa-code',
                    'url'          => route('customer.orders'),
                ],
                (object)[
                    'id'           => 103,
                    'title'        => 'Digital Marketing Course',
                    'amount'       => 2999,
                    'status'       => 'Completed',
                    'status_class' => 'bg-info-subtle text-info-emphasis',
                    'date'         => 'Oct 26, 2026',
                    'icon'         => 'fa-solid fa-graduation-cap',
                    'url'          => route('customer.orders'),
                ],
                (object)[
                    'id'           => 104,
                    'title'        => 'Business Listing (Premium)',
                    'amount'       => 1499,
                    'status'       => 'Active',
                    'status_class' => 'bg-primary-subtle text-primary',
                    'date'         => 'Oct 24, 2026',
                    'icon'         => 'fa-solid fa-building-columns',
                    'url'          => route('customer.orders'),
                ],
            ]);
        }

        // 4. Recommended for You (Courses, Services, Products, Businesses)
        $recommendedCourses = collect();
        if (Schema::hasTable('dc_elearn_course')) {
            $recommendedCourses = ElearnCourse::where('is_featured', 1)
                ->orWhere('is_trending', 1)
                ->latest('id')
                ->take(4)
                ->get();
        }
        if ($recommendedCourses->isEmpty() && Schema::hasTable('courses')) {
            $recommendedCourses = Course::latest('id')->take(4)->get();
        }

        // Recommended Services
        $recommendedServices = Service::latest('id')->take(4)->get();

        // Recommended Products
        $recommendedProducts = Product::latest('id')->take(4)->get();

        // Recommended Businesses
        $recommendedBusinesses = BusinessListing::latest('id')->take(4)->get();

        // Popular Categories with counts
        $popularCategories = [
            [
                'title' => 'Digital Marketing Courses',
                'count' => '1,200+ courses',
                'icon'  => 'fa-solid fa-graduation-cap text-primary',
                'bg'    => '#eff6ff',
                'url'   => route('courses', ['category' => 'Digital Marketing']),
            ],
            [
                'title' => 'Website Development',
                'count' => '800+ services',
                'icon'  => 'fa-solid fa-code text-info',
                'bg'    => '#f0fdfa',
                'url'   => route('services', ['category' => 'Website Development']),
            ],
            [
                'title' => 'Laptops & Computers',
                'count' => '1,500+ products',
                'icon'  => 'fa-solid fa-laptop text-success',
                'bg'    => '#f0fdf4',
                'url'   => route('products', ['search' => 'Laptop']),
            ],
            [
                'title' => 'Coaching Institutes',
                'count' => '600+ businesses',
                'icon'  => 'fa-solid fa-building-columns text-warning',
                'bg'    => '#fefce8',
                'url'   => route('businesses', ['category' => 'Coaching Institute']),
            ],
            [
                'title' => 'Graphic Design',
                'count' => '900+ services',
                'icon'  => 'fa-solid fa-palette text-danger',
                'bg'    => '#fdf2f8',
                'url'   => route('services', ['category' => 'Graphic Design']),
            ],
        ];

        return view('customer.dashboard', [
            'user'                  => $user,
            'enrolledCourses'       => $enrolledCourses,
            'myOrders'              => $myOrders,
            'recommendedCourses'    => $recommendedCourses,
            'recommendedServices'   => $recommendedServices,
            'recommendedProducts'   => $recommendedProducts,
            'recommendedBusinesses' => $recommendedBusinesses,
            'popularCategories'     => $popularCategories,
        ]);
    }

    /**
     * Helper to auto-sync any completed order for course enrollments.
     */
    protected function syncPurchasedOrders($user): void
    {
        if (empty($user->id)) return;

        $orders = Order::where(function ($q) use ($user) {
            if (!empty($user->email)) $q->where('customer_email', $user->email);
            if (!empty($user->phone)) $q->orWhere('customer_phone', $user->phone);
        })
        ->whereIn('status', ['confirmed', 'completed', 'processing', 'in_progress', 'Delivered'])
        ->get();

        foreach ($orders as $order) {
            $course = null;
            $courseType = 'catalog';

            if (Schema::hasTable('dc_elearn_course')) {
                $course = ElearnCourse::where('course_name', $order->item_title)->first();
                if (!$course && preg_match('/\[ID:\s*(\d+)\]/', $order->item_subtext ?? '', $matches)) {
                    $course = ElearnCourse::find((int)$matches[1]);
                }
                if ($course) $courseType = 'elearn';
            }

            if (!$course && Schema::hasTable('courses')) {
                $course = Course::where('title', $order->item_title)->first();
                $courseType = 'catalog';
            }

            if ($course) {
                CourseEnrollment::firstOrCreate(
                    [
                        'user_id'     => $user->id,
                        'course_id'   => $course->id,
                        'course_type' => $courseType,
                    ],
                    [
                        'order_id'         => $order->id,
                        'enrolled_at'      => $order->placed_at ?? $order->created_at,
                        'status'           => 'active',
                        'progress_percent' => 0,
                    ]
                );
            }
        }
    }

    /**
     * Display the student's booked / hired services page.
     */
    public function services(Request $request): View
    {
        $user = Auth::guard('web')->user() ?: (object)[
            'id'    => 1,
            'name'  => 'Hitesh Mohkar',
            'email' => 'student@digitalclassworld.in',
            'phone' => '9876543210',
            'profession' => 'Student',
        ];

        $services = collect();
        if (Auth::guard('web')->check() && (!empty($user->email) || !empty($user->phone))) {
            $services = Order::where(function($q) use ($user) {
                    if (!empty($user->email)) $q->where('customer_email', $user->email);
                    if (!empty($user->phone)) $q->orWhere('customer_phone', $user->phone);
                })
                ->where(function($q) {
                    $q->where('order_type', 'service')
                      ->orWhere('item_title', 'like', '%service%')
                      ->orWhere('item_subtext', 'like', '%service%')
                      ->orWhere('item_title', 'like', '%development%')
                      ->orWhere('item_title', 'like', '%design%')
                      ->orWhere('item_title', 'like', '%marketing%');
                })
                ->latest('placed_at')
                ->latest('id')
                ->get();
        }

        return view('customer.services', compact('services', 'user'));
    }

    /**
     * Display the student's business inquiries / institute admissions page.
     */
    public function businesses(Request $request): View
    {
        $user = Auth::guard('web')->user() ?: (object)[
            'id'    => 1,
            'name'  => 'Hitesh Mohkar',
            'email' => 'student@digitalclassworld.in',
            'phone' => '9876543210',
            'profession' => 'Student',
        ];

        $inquiries = collect(session('customer_business_inquiries', []));

        // If leads table exists, query leads matching user
        if (Schema::hasTable('leads') && Auth::guard('web')->check()) {
            $dbLeads = \App\Models\Lead::where(function($q) use ($user) {
                if (!empty($user->email)) $q->where('email', $user->email);
                if (!empty($user->phone)) $q->orWhere('phone', $user->phone);
            })->latest()->get();

            foreach ($dbLeads as $lead) {
                $inquiries->push((object)[
                    'id'            => $lead->id,
                    'business_name' => $lead->source ?: 'Verified Training Institute',
                    'category'      => $lead->interested_in ?: 'Coaching & Training',
                    'message'       => $lead->remarks ?: 'Course admission and syllabus enquiry submitted.',
                    'status'        => $lead->status ?: 'Under Review',
                    'date'          => $lead->created_at ? $lead->created_at->format('M d, Y') : now()->format('M d, Y'),
                ]);
            }
        }

        return view('customer.businesses', compact('inquiries', 'user'));
    }

    /**
     * Display the student's wishlist page (full dedicated page, no popup).
     */
    public function wishlist(Request $request): View
    {
        $user = Auth::guard('web')->user() ?: (object)[
            'id'    => 1,
            'name'  => 'Hitesh Mohkar',
            'email' => 'student@digitalclassworld.in',
            'phone' => '9876543210',
            'profession' => 'Student',
        ];

        $wishlist = session('wishlist');
        if ($wishlist === null) {
            $wishlist = [
                1 => [
                    'id'        => 1,
                    'title'     => 'Python for Beginners & Data Science',
                    'type'      => 'Course',
                    'provider'  => 'VCEC Computer Education',
                    'price'     => 1499,
                    'mrp'       => 3999,
                    'rating'    => 4.9,
                    'reviews'   => 128,
                    'thumbnail' => 'https://images.unsplash.com/photo-1516321318423-f06f85e504b3?w=500&auto=format&fit=crop&q=80',
                    'url'       => route('courses', ['search' => 'Python']),
                ],
                2 => [
                    'id'        => 2,
                    'title'     => 'Full Stack Web Development Bootcamp',
                    'type'      => 'Course',
                    'provider'  => 'Rahul Academy',
                    'price'     => 2999,
                    'mrp'       => 7999,
                    'rating'    => 4.8,
                    'reviews'   => 94,
                    'thumbnail' => 'https://images.unsplash.com/photo-1460925895917-afdab827c52f?w=500&auto=format&fit=crop&q=80',
                    'url'       => route('courses', ['search' => 'Web Development']),
                ],
                3 => [
                    'id'        => 3,
                    'title'     => 'Graphic Design & UI/UX Branding Package',
                    'type'      => 'Service',
                    'provider'  => 'Krisha Patel',
                    'price'     => 1500,
                    'mrp'       => 3500,
                    'rating'    => 4.9,
                    'reviews'   => 45,
                    'thumbnail' => 'https://images.unsplash.com/photo-1556761175-5973dc0f32e7?w=500&auto=format&fit=crop&q=80',
                    'url'       => route('services', ['search' => 'Graphic Design']),
                ],
            ];
            session(['wishlist' => $wishlist]);
        }

        $wishlistItems = collect($wishlist);

        return view('customer.wishlist', compact('wishlistItems', 'user'));
    }

    /**
     * Remove item from wishlist.
     */
    public function removeFromWishlist(Request $request, $id)
    {
        $wishlist = session('wishlist', []);
        if (isset($wishlist[$id])) {
            unset($wishlist[$id]);
        } else {
            foreach ($wishlist as $k => $item) {
                if (($item['id'] ?? null) == $id) {
                    unset($wishlist[$k]);
                    break;
                }
            }
        }
        session(['wishlist' => $wishlist]);

        if ($request->wantsJson() || $request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'Item removed from your wishlist.',
                'count'   => count($wishlist),
            ]);
        }

        return back()->with('success', 'Item removed from your wishlist successfully.');
    }

    /**
     * Clear all items from wishlist.
     */
    public function clearWishlist(Request $request)
    {
        session(['wishlist' => []]);

        if ($request->wantsJson() || $request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'Your wishlist has been cleared.',
                'count'   => 0,
            ]);
        }

        return back()->with('success', 'Your wishlist has been cleared.');
    }

    /**
     * Toggle item in wishlist.
     */
    public function toggleWishlist(Request $request)
    {
        $id = $request->input('id');
        $title = $request->input('title', 'Item');
        $type = $request->input('type', 'Course');
        $price = $request->input('price', 999);
        $provider = $request->input('provider', 'Digital Class');
        $thumbnail = $request->input('thumbnail', 'https://images.unsplash.com/photo-1516321318423-f06f85e504b3?w=500&auto=format&fit=crop&q=80');

        $wishlist = session('wishlist', []);
        if (isset($wishlist[$id])) {
            unset($wishlist[$id]);
            session(['wishlist' => $wishlist]);
            return response()->json(['status' => 'removed', 'count' => count($wishlist)]);
        } else {
            $wishlist[$id] = [
                'id'        => $id,
                'title'     => $title,
                'type'      => $type,
                'provider'  => $provider,
                'price'     => $price,
                'mrp'       => round($price * 1.8),
                'rating'    => 4.9,
                'reviews'   => 50,
                'thumbnail' => $thumbnail,
                'url'       => route('courses'),
            ];
            session(['wishlist' => $wishlist]);
            return response()->json(['status' => 'added', 'count' => count($wishlist)]);
        }
    }

    /**
     * Display student support messages center (clean, no static fake data).
     */
    public function messages(Request $request): View
    {
        $user = Auth::guard('web')->user() ?: (object)[
            'id'    => 1,
            'name'  => 'Hitesh Mohkar',
            'email' => 'student@digitalclassworld.in',
            'phone' => '9876543210',
            'profession' => 'Student',
        ];

        // 1. Digital Class Support Tickets & Inquiries
        $conversations = collect();
        if (Schema::hasTable('support_tickets') && Auth::guard('web')->check() && (!empty($user->email) || !empty($user->phone))) {
            try {
                $conversations = \App\Models\SupportTicket::where(function($q) use ($user) {
                        if (!empty($user->email)) $q->where('customer_email', $user->email);
                        if (!empty($user->phone)) $q->orWhere('customer_phone', $user->phone);
                    })
                    ->with('messages')
                    ->latest()
                    ->get();
            } catch (\Throwable $e) {
                \Illuminate\Support\Facades\Log::warning('Support tickets fetch note: ' . $e->getMessage());
            }
        }

        // 2. Direct Seller Conversations (Customer <-> Seller Chats)
        $sellerChats = collect();
        if (Schema::hasTable('conversations') && Auth::guard('web')->check() && (!empty($user->email) || !empty($user->phone))) {
            try {
                $sellerChats = \App\Models\Conversation::where(function($q) use ($user) {
                        if (!empty($user->email)) $q->where('customer_email', $user->email);
                        if (!empty($user->phone)) $q->orWhere('customer_phone', $user->phone);
                    })
                    ->with(['seller.businessDetail', 'seller.user', 'messages'])
                    ->latest('last_message_at')
                    ->get();
            } catch (\Throwable $e) {
                \Illuminate\Support\Facades\Log::warning('Seller conversations fetch note: ' . $e->getMessage());
            }
        }

        // Available sellers/instructors list for starting a new chat
        // We prioritize sellers who have active courses, services, or business listings, plus all active sellers
        $availableSellers = collect();
        if (Schema::hasTable('sellers')) {
            try {
                // Get active sellers with their business details and users
                $availableSellers = \App\Models\Seller::where('seller_status', 'Active')
                    ->with(['businessDetail', 'user'])
                    ->orderByRaw("CASE 
                        WHEN id IN (SELECT DISTINCT seller_id FROM courses WHERE seller_id IS NOT NULL) THEN 1 
                        WHEN id IN (SELECT DISTINCT seller_id FROM services WHERE seller_id IS NOT NULL) THEN 2 
                        WHEN id IN (SELECT DISTINCT seller_id FROM business_listings WHERE seller_id IS NOT NULL) THEN 3 
                        ELSE 4 
                    END")
                    ->orderBy('id', 'asc')
                    ->get();

                if ($availableSellers->isEmpty()) {
                    $availableSellers = \App\Models\Seller::with(['businessDetail', 'user'])->get();
                }
            } catch (\Throwable $e) {
                \Illuminate\Support\Facades\Log::warning('Available sellers fetch note: ' . $e->getMessage());
                // Fallback safe collection
                $availableSellers = \App\Models\Seller::with(['businessDetail', 'user'])->take(200)->get();
            }
        }

        // Available marketplace courses for inquiry dropdown
        $availableCourses = collect();
        if (Schema::hasTable('courses')) {
            try {
                $availableCourses = \App\Models\Course::select('id', 'title', 'seller_id', 'price', 'discount_price')
                    ->with(['seller.businessDetail', 'seller.user'])
                    ->orderBy('title', 'asc')
                    ->get();
            } catch (\Throwable $e) {
                \Illuminate\Support\Facades\Log::warning('Available courses fetch note: ' . $e->getMessage());
            }
        }

        $sessionMessages = session('customer_sent_messages', []);

        $activeTab = $request->query('tab', 'support'); // 'support' or 'sellers'
        $activeChatId = $request->query('chat_id');
        $activeSellerChat = null;
        if ($activeChatId && $sellerChats->isNotEmpty()) {
            $activeSellerChat = $sellerChats->firstWhere('id', (int)$activeChatId);
        }
        if (!$activeSellerChat && $sellerChats->isNotEmpty()) {
            $activeSellerChat = $sellerChats->first();
        }

        return view('customer.messages', compact(
            'user',
            'conversations',
            'sellerChats',
            'availableSellers',
            'availableCourses',
            'sessionMessages',
            'activeTab',
            'activeSellerChat'
        ));
    }

    /**
     * Send a support message / inquiry or message to a seller.
     */
    public function sendMessage(Request $request)
    {
        $target = $request->input('target', 'support'); // 'support' or 'seller'

        if ($target === 'seller') {
            return $this->sendSellerMessage($request);
        }

        $validated = $request->validate([
            'subject' => 'nullable|string|max:150',
            'message' => 'required|string|max:2000',
        ]);

        $user = Auth::guard('web')->user();

        if ($user && Schema::hasTable('support_tickets')) {
            try {
                $ticket = \App\Models\SupportTicket::create([
                    'ticket_number'   => 'TICK-' . strtoupper(substr(uniqid(), -6)),
                    'customer_name'   => $user->name ?: 'Customer',
                    'customer_email'  => $user->email,
                    'customer_phone'  => $user->phone,
                    'category'        => $validated['subject'] ?: 'General Support',
                    'priority'        => 'Medium',
                    'status'          => 'Open',
                    'last_message'    => $validated['message'],
                    'last_message_at' => now(),
                    'is_unread'       => true,
                ]);

                if (Schema::hasTable('support_ticket_messages')) {
                    \App\Models\SupportTicketMessage::create([
                        'ticket_id'   => $ticket->id,
                        'sender_type' => 'customer',
                        'sender_name' => $user->name ?: 'Customer',
                        'message'     => $validated['message'],
                    ]);
                }
            } catch (\Throwable $e) {
                \Illuminate\Support\Facades\Log::warning('Support ticket creation error: ' . $e->getMessage());
            }
        }

        $sessionMessages = session('customer_sent_messages', []);
        $sessionMessages[] = [
            'id'         => count($sessionMessages) + 1,
            'subject'    => $validated['subject'] ?: 'General Support Inquiry',
            'message'    => $validated['message'],
            'created_at' => now()->format('M d, Y h:i A'),
            'status'     => 'Received by Support',
        ];
        session(['customer_sent_messages' => $sessionMessages]);

        return redirect()->route('customer.messages', ['tab' => 'support'])
            ->with('success', 'Your message has been sent to Digital Class Support! Our team will respond shortly.');
    }

    /**
     * Send or reply to a message for a specific seller.
     */
    public function sendSellerMessage(Request $request)
    {
        $validated = $request->validate([
            'seller_id'       => 'nullable|integer',
            'course_id'       => 'nullable|integer',
            'conversation_id' => 'nullable|integer',
            'subject_title'   => 'nullable|string|max:200',
            'message'         => 'required|string|max:3000',
        ]);

        $user = Auth::guard('web')->user();
        if (!$user) {
            return redirect()->route('login')->with('error', 'Please login to message sellers.');
        }

        $course = null;
        if (!empty($validated['course_id']) && Schema::hasTable('courses')) {
            $course = \App\Models\Course::with('seller')->find($validated['course_id']);
            if ($course && empty($validated['seller_id'])) {
                $validated['seller_id'] = $course->seller_id;
            }
        }

        $conversation = null;

        // If replying to existing conversation
        if (!empty($validated['conversation_id']) && Schema::hasTable('conversations')) {
            $conversation = \App\Models\Conversation::find($validated['conversation_id']);
        }

        // If starting a new conversation with a seller
        if (!$conversation && !empty($validated['seller_id']) && Schema::hasTable('conversations')) {
            $seller = \App\Models\Seller::find($validated['seller_id']);
            if ($seller) {
                // Find existing conversation between this customer and seller, or create new
                $conversation = \App\Models\Conversation::where('seller_id', $seller->id)
                    ->where(function($q) use ($user) {
                        if ($user->email) $q->where('customer_email', $user->email);
                        if ($user->phone) $q->orWhere('customer_phone', $user->phone);
                    })
                    ->first();

                $subjectTitle = $validated['subject_title'];
                if (empty($subjectTitle)) {
                    if ($course) {
                        $subjectTitle = 'Inquiry for Course: ' . $course->title;
                    } else {
                        $subjectTitle = 'Query for ' . $seller->store_name;
                    }
                }

                if (!$conversation) {
                    $conversation = \App\Models\Conversation::create([
                        'seller_id'              => $seller->id,
                        'customer_name'          => $user->name ?: 'Customer',
                        'customer_email'         => $user->email ?: 'customer@digitalclassworld.in',
                        'customer_phone'         => $user->phone,
                        'customer_avatar'        => $user->avatar,
                        'customer_city'          => $user->city,
                        'customer_online_status' => 'Online',
                        'subject_title'          => $subjectTitle,
                        'subject_type'           => $course ? ('Course: #' . $course->id) : 'Course / Service Query',
                        'subject_thumbnail'      => $course?->thumbnail,
                        'category'               => 'inquiries',
                        'status'                 => 'Active',
                        'total_messages'         => 0,
                        'unread_count'           => 1,
                        'last_message'           => $validated['message'],
                        'last_message_at'        => now(),
                        'active_since'           => now(),
                    ]);
                } else if ($course) {
                    // Update subject title if asking about a specific course
                    $conversation->update([
                        'subject_title' => $subjectTitle,
                        'subject_type'  => 'Course: #' . $course->id,
                        'subject_thumbnail' => $course->thumbnail ?: $conversation->subject_thumbnail,
                    ]);
                }
            }
        }

        if ($conversation && Schema::hasTable('messages')) {
            \App\Models\Message::create([
                'conversation_id' => $conversation->id,
                'sender_type'     => 'customer',
                'sender_id'       => $user->id,
                'sender_name'     => $user->name ?: 'Customer',
                'message'         => $validated['message'],
                'is_read'         => false,
            ]);

            $conversation->update([
                'last_message'    => $validated['message'],
                'last_message_at' => now(),
                'unread_count'    => ($conversation->unread_count ?? 0) + 1,
                'total_messages'  => $conversation->messages()->count(),
            ]);

            return redirect()->route('customer.messages', [
                'tab'     => 'sellers',
                'chat_id' => $conversation->id,
            ])->with('success', 'Your message has been sent to the seller!');
        }

        return redirect()->route('customer.messages', ['tab' => 'sellers'])
            ->with('error', 'Could not locate seller conversation. Please select a valid seller.');
    }
}
