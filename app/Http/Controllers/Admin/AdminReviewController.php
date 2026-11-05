<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Review;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Symfony\Component\HttpFoundation\StreamedResponse;

class AdminReviewController extends Controller
{
    /**
     * Display Reviews & Ratings Management matching screenshot pixel-for-pixel.
     */
    public function index(Request $request): View
    {
        $tab = $request->query('tab', 'all');
        $search = $request->query('search');
        $typeFilter = $request->query('type');
        $ratingFilter = $request->query('rating');
        $statusFilter = $request->query('status');
        $platformFilter = $request->query('platform');
        $categoryFilter = $request->query('category');
        $withPhotos = $request->query('with_photos');
        $flaggedOnly = $request->query('flagged_only');

        $showDummy = config('marketplace.show_dummy_data', app()->environment('local', 'testing'));

        $dbReviews = Review::latest()->get();

        $curatedReviews = $showDummy ? $this->getCuratedReviews() : [];

        // Merge DB reviews
        foreach ($dbReviews as $rev) {
            // Avoid duplicate if seeded with same item and user
            $exists = collect($curatedReviews)->contains(function ($c) use ($rev) {
                return $c['user_name'] === $rev->user_name && $c['item_title'] === $rev->item_title;
            });

            if (!$exists) {
                $curatedReviews[] = [
                    'id'                => $rev->id,
                    'user_name'         => $rev->user_name,
                    'user_email'        => $rev->user_email ?: 'user@example.com',
                    'user_city'         => $rev->user_city ?: 'Ahmedabad, Gujarat',
                    'user_avatar'       => $rev->user_avatar ?: 'https://ui-avatars.com/api/?name=' . urlencode($rev->user_name) . '&background=0066ff&color=fff',
                    'rating'            => (float) $rev->rating,
                    'review_text'       => $rev->review_text,
                    'review_type'       => $rev->review_type ?: 'Course',
                    'item_title'        => $rev->item_title,
                    'item_thumbnail'    => $rev->item_thumbnail ?: 'https://images.unsplash.com/photo-1516321318423-f06f85e504b3?w=120&auto=format&fit=crop&q=80',
                    'seller_name'       => $rev->seller_name ?: 'Verified Instructor',
                    'category'          => $rev->category ?: 'General',
                    'order_id'          => $rev->order_id ?: ('ORD' . str_pad($rev->id, 6, '0', STR_PAD_LEFT)),
                    'enrolled_on'       => $rev->enrolled_on ? $rev->enrolled_on->format('d M Y') : '28 Oct 2026',
                    'completed_on'      => $rev->completed_on ? $rev->completed_on->format('d M Y') : '30 Oct 2026',
                    'photos'            => is_array($rev->photos) ? $rev->photos : (json_decode($rev->photos, true) ?: []),
                    'date_formatted'    => $rev->created_at ? $rev->created_at->format('d M Y') : '30 Oct 2026',
                    'time_formatted'    => $rev->created_at ? $rev->created_at->format('h:i A') : '10:24 AM',
                    'status'            => $rev->status ?: 'Approved',
                    'helpful_upvotes'   => $rev->helpful_upvotes ?? 0,
                    'helpful_downvotes' => $rev->helpful_downvotes ?? 0,
                    'admin_notes'       => $rev->admin_notes,
                    'is_featured'       => (bool) $rev->is_featured,
                ];
            }
        }

        $allReviews = collect($curatedReviews);

        // Apply Tab Filter
        if ($tab && $tab !== 'all') {
            if ($tab === 'pending') {
                $allReviews = $allReviews->filter(fn($r) => strtolower($r['status']) === 'pending');
            } elseif ($tab === 'approved') {
                $allReviews = $allReviews->filter(fn($r) => strtolower($r['status']) === 'approved');
            } elseif ($tab === 'rejected') {
                $allReviews = $allReviews->filter(fn($r) => strtolower($r['status']) === 'rejected');
            } elseif ($tab === 'flagged') {
                $allReviews = $allReviews->filter(fn($r) => strtolower($r['status']) === 'flagged');
            }
        }

        // Apply Search Filter
        if (!empty($search)) {
            $q = strtolower($search);
            $allReviews = $allReviews->filter(function ($r) use ($q) {
                return str_contains(strtolower($r['user_name']), $q)
                    || str_contains(strtolower($r['review_text']), $q)
                    || str_contains(strtolower($r['item_title']), $q)
                    || str_contains(strtolower($r['seller_name']), $q)
                    || str_contains(strtolower($r['user_city']), $q);
            });
        }

        // Apply Type Filter
        if (!empty($typeFilter) && $typeFilter !== 'all') {
            $allReviews = $allReviews->filter(fn($r) => strtolower($r['review_type']) === strtolower($typeFilter));
        }

        // Apply Rating Filter
        if (!empty($ratingFilter) && $ratingFilter !== 'all') {
            $rVal = (float) $ratingFilter;
            $allReviews = $allReviews->filter(fn($r) => floor($r['rating']) == $rVal);
        }

        // Apply Status Filter
        if (!empty($statusFilter) && $statusFilter !== 'all') {
            $allReviews = $allReviews->filter(fn($r) => strtolower($r['status']) === strtolower($statusFilter));
        }

        // Apply With Photos Filter
        if (!empty($withPhotos) && $withPhotos !== 'all') {
            if ($withPhotos === 'yes') {
                $allReviews = $allReviews->filter(fn($r) => !empty($r['photos']));
            } elseif ($withPhotos === 'no') {
                $allReviews = $allReviews->filter(fn($r) => empty($r['photos']));
            }
        }

        // Apply Flagged Only Filter
        if (!empty($flaggedOnly) && $flaggedOnly !== 'all') {
            $allReviews = $allReviews->filter(fn($r) => strtolower($r['status']) === 'flagged');
        }

        // 5 KPI Cards matching Screenshot
        if (!$showDummy) {
            $totalCount = Review::count();
            $approvedCount = Review::where('status', 'Approved')->count();
            $pendingCount = Review::where('status', 'Pending')->count();
            $rejectedCount = Review::where('status', 'Rejected')->count();
            $flaggedCount = Review::where('status', 'Flagged')->count();
            $avgRating = $totalCount > 0 ? round(Review::avg('rating'), 1) : 5.0;

            $stats = [
                'total_reviews'     => number_format($totalCount),
                'reviews_growth'    => '+0%',
                'reviews_sub'       => '+' . Review::where('created_at', '>=', now()->startOfMonth())->count() . ' this month',
                'average_rating'    => $avgRating . ' / 5',
                'rating_sub'        => '+0.0 from last month',
                'approved'          => number_format($approvedCount),
                'approved_sub'      => $totalCount > 0 ? round(($approvedCount / $totalCount) * 100) . '% of total' : '100% of total',
                'pending'           => number_format($pendingCount),
                'pending_sub'       => $totalCount > 0 ? round(($pendingCount / $totalCount) * 100) . '% of total' : '0% of total',
                'rejected'          => number_format($rejectedCount),
                'rejected_sub'      => $totalCount > 0 ? round(($rejectedCount / $totalCount) * 100) . '% of total' : '0% of total',
            ];

            $counts = [
                'all'       => $totalCount,
                'pending'   => $pendingCount,
                'approved'  => $approvedCount,
                'rejected'  => $rejectedCount,
                'flagged'   => $flaggedCount,
            ];
        } else {
            $stats = [
                'total_reviews'     => '3,420',
                'reviews_growth'    => '+18%',
                'reviews_sub'       => '+520 this month',
                'average_rating'    => '4.6 / 5',
                'rating_sub'        => '+0.3 from last month',
                'approved'          => '3,180',
                'approved_sub'      => '93% of total',
                'pending'           => '160',
                'pending_sub'       => '5% of total',
                'rejected'          => '80',
                'rejected_sub'      => '2% of total',
            ];

            $counts = [
                'all'       => 3420,
                'pending'   => 160,
                'approved'  => 3180,
                'rejected'  => 80,
                'flagged'   => 24,
            ];
        }

        return view('admin.reviews.index', [
            'reviews'          => $allReviews->values(),
            'stats'            => $stats,
            'counts'           => $counts,
            'currentTab'       => $tab,
            'searchQuery'      => $search,
            'typeFilter'       => $typeFilter,
            'ratingFilter'     => $ratingFilter,
            'statusFilter'     => $statusFilter,
            'platformFilter'   => $platformFilter,
            'categoryFilter'   => $categoryFilter,
            'withPhotos'       => $withPhotos,
            'flaggedOnly'      => $flaggedOnly,
        ]);
    }

    /**
     * Approve a review.
     */
    public function approve($id): RedirectResponse
    {
        $review = Review::find($id);
        if ($review) {
            $review->update(['status' => 'Approved']);
        }

        return back()->with('success', "Review #{$id} has been approved and published to the marketplace.");
    }

    /**
     * Reject a review.
     */
    public function reject(Request $request, $id): RedirectResponse
    {
        $review = Review::find($id);
        if ($review) {
            $review->update(['status' => 'Rejected']);
        }

        return back()->with('success', "Review #{$id} has been marked as rejected.");
    }

    /**
     * Toggle featured status of review.
     */
    public function toggleFeatured($id): RedirectResponse
    {
        $review = Review::find($id);
        if ($review) {
            $review->update(['is_featured' => !$review->is_featured]);
        }

        return back()->with('success', "Review #{$id} featured status updated successfully.");
    }

    /**
     * Delete review permanently.
     */
    public function destroy($id): RedirectResponse
    {
        $review = Review::find($id);
        if ($review) {
            $review->delete();
        }

        return back()->with('success', "Review #{$id} has been permanently deleted.");
    }

    /**
     * Save internal admin note on review.
     */
    public function saveNote(Request $request, $id): RedirectResponse
    {
        $request->validate([
            'admin_notes' => 'required|string|max:1000',
        ]);

        $review = Review::find($id);
        if ($review) {
            $review->update(['admin_notes' => $request->input('admin_notes')]);
        }

        return back()->with('success', "Internal admin note saved for review #{$id}.");
    }

    /**
     * Export reviews as CSV.
     */
    public function export(Request $request): StreamedResponse
    {
        $reviews = $this->getCuratedReviews();

        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => "attachment; filename=\"reviews-export-" . date('Y-m-d') . ".csv\"",
            'Pragma' => 'no-cache',
            'Cache-Control' => 'must-revalidate, post-check=0, pre-check=0',
            'Expires' => '0',
        ];

        return response()->stream(function () use ($reviews) {
            $handle = fopen('php://output', 'w');
            fputcsv($handle, ['ID', 'User Name', 'City', 'Rating', 'Review Details', 'Type', 'Item Title', 'Seller', 'Date', 'Status']);

            foreach ($reviews as $r) {
                fputcsv($handle, [
                    $r['id'],
                    $r['user_name'],
                    $r['user_city'],
                    $r['rating'],
                    $r['review_text'],
                    $r['review_type'],
                    $r['item_title'],
                    $r['seller_name'],
                    $r['date_formatted'] . ' ' . $r['time_formatted'],
                    $r['status'],
                ]);
            }
            fclose($handle);
        }, 200, $headers);
    }

    /**
     * Curated 10 reviews matching screenshot pixel-for-pixel.
     */
    public function getCuratedReviews(): array
    {
        return [
            [
                'id'                => 1,
                'user_name'         => 'Priya Patel',
                'user_email'        => 'priya.patel@mail.com',
                'user_city'         => 'Ahmedabad, Gujarat',
                'user_avatar'       => 'https://images.unsplash.com/photo-1494790108377-be9c29b29330?w=100&auto=format&fit=crop&q=80',
                'rating'            => 5.0,
                'review_text'       => 'Excellent course! Very useful for beginners. The trainer explains everything in a simple way. Highly recommended for anyone looking to start a digital marketing.',
                'review_type'       => 'Course',
                'item_title'        => 'Digital Marketing Mastery',
                'item_thumbnail'    => 'https://images.unsplash.com/photo-1432888622747-4eb9a8efeb07?w=120&auto=format&fit=crop&q=80',
                'seller_name'       => 'Tech Skills Academy',
                'category'          => 'Digital Marketing',
                'order_id'          => 'ORD001245',
                'enrolled_on'       => '28 Oct 2026',
                'completed_on'      => '30 Oct 2026',
                'photos'            => [
                    'https://images.unsplash.com/photo-1516321318423-f06f85e504b3?w=300&auto=format&fit=crop&q=80',
                    'https://images.unsplash.com/photo-1531482615713-2afd69097998?w=300&auto=format&fit=crop&q=80',
                    'https://images.unsplash.com/photo-1522202176988-66273c2fd55f?w=300&auto=format&fit=crop&q=80',
                    'https://images.unsplash.com/photo-1454165804606-c3d57bc86b40?w=300&auto=format&fit=crop&q=80',
                ],
                'date_formatted'    => '30 Oct 2026',
                'time_formatted'    => '10:24 AM',
                'status'            => 'Approved',
                'helpful_upvotes'   => 24,
                'helpful_downvotes' => 2,
                'admin_notes'       => 'Verified high-quality student review with certification proof.',
                'is_featured'       => true,
            ],
            [
                'id'                => 2,
                'user_name'         => 'Rahul Sharma',
                'user_email'        => 'rahul.sharma@mail.com',
                'user_city'         => 'Surat, Gujarat',
                'user_avatar'       => 'https://images.unsplash.com/photo-1535713875002-d1d0cf377fde?w=100&auto=format&fit=crop&q=80',
                'rating'            => 4.0,
                'review_text'       => 'Good service and quick support. Team is very responsive and delivered before deadline.',
                'review_type'       => 'Service',
                'item_title'        => 'Website Development',
                'item_thumbnail'    => 'https://images.unsplash.com/photo-1547658719-da2b51169166?w=120&auto=format&fit=crop&q=80',
                'seller_name'       => 'Design Studio Pro',
                'category'          => 'Development',
                'order_id'          => 'ORD001244',
                'enrolled_on'       => '25 Oct 2026',
                'completed_on'      => '28 Oct 2026',
                'photos'            => [],
                'date_formatted'    => '28 Oct 2026',
                'time_formatted'    => '04:15 PM',
                'status'            => 'Approved',
                'helpful_upvotes'   => 12,
                'helpful_downvotes' => 1,
                'admin_notes'       => null,
                'is_featured'       => false,
            ],
            [
                'id'                => 3,
                'user_name'         => 'Amit Kumar',
                'user_email'        => 'amit.kumar@mail.com',
                'user_city'         => 'Vadodara, Gujarat',
                'user_avatar'       => 'https://images.unsplash.com/photo-1570295999919-56ceb5ecca61?w=100&auto=format&fit=crop&q=80',
                'rating'            => 4.0,
                'review_text'       => 'Nice product quality. Delivery was on time and packaging was neat.',
                'review_type'       => 'Product',
                'item_title'        => 'HP Laptop 15s',
                'item_thumbnail'    => 'https://images.unsplash.com/photo-1496181133206-80ce9b88a853?w=120&auto=format&fit=crop&q=80',
                'seller_name'       => 'Tech World',
                'category'          => 'Computers',
                'order_id'          => 'ORD001243',
                'enrolled_on'       => '22 Oct 2026',
                'completed_on'      => '26 Oct 2026',
                'photos'            => [
                    'https://images.unsplash.com/photo-1496181133206-80ce9b88a853?w=300&auto=format&fit=crop&q=80',
                ],
                'date_formatted'    => '26 Oct 2026',
                'time_formatted'    => '11:32 AM',
                'status'            => 'Approved',
                'helpful_upvotes'   => 8,
                'helpful_downvotes' => 0,
                'admin_notes'       => null,
                'is_featured'       => false,
            ],
            [
                'id'                => 4,
                'user_name'         => 'Neha Mehta',
                'user_email'        => 'neha.mehta@mail.com',
                'user_city'         => 'Ahmedabad, Gujarat',
                'user_avatar'       => 'https://images.unsplash.com/photo-1544005313-94ddf0286df2?w=100&auto=format&fit=crop&q=80',
                'rating'            => 2.0,
                'review_text'       => 'Not satisfied with the support. Ticket took too long to resolve.',
                'review_type'       => 'Service',
                'item_title'        => 'GST Registration Service',
                'item_thumbnail'    => 'https://images.unsplash.com/photo-1554224155-8d04cb21cd6c?w=120&auto=format&fit=crop&q=80',
                'seller_name'       => 'Tax Pro Solutions',
                'category'          => 'Legal & Finance',
                'order_id'          => 'ORD001240',
                'enrolled_on'       => '20 Oct 2026',
                'completed_on'      => '24 Oct 2026',
                'photos'            => [],
                'date_formatted'    => '24 Oct 2026',
                'time_formatted'    => '02:10 PM',
                'status'            => 'Pending',
                'helpful_upvotes'   => 3,
                'helpful_downvotes' => 4,
                'admin_notes'       => 'Customer support contacted the user to resolve dispute.',
                'is_featured'       => false,
            ],
            [
                'id'                => 5,
                'user_name'         => 'Karan Singh',
                'user_email'        => 'karan.singh@mail.com',
                'user_city'         => 'Rajkot, Gujarat',
                'user_avatar'       => 'https://images.unsplash.com/photo-1506794778202-cad84cf45f1d?w=100&auto=format&fit=crop&q=80',
                'rating'            => 5.0,
                'review_text'       => 'Best institute in the city. Highly recommended! Faculty members are highly knowledgeable.',
                'review_type'       => 'Business',
                'item_title'        => 'VCEC Computer Institute',
                'item_thumbnail'    => 'https://images.unsplash.com/photo-1524178232363-1fb2b075b655?w=120&auto=format&fit=crop&q=80',
                'seller_name'       => 'VCEC Institute',
                'category'          => 'Education',
                'order_id'          => 'ORD001238',
                'enrolled_on'       => '18 Oct 2026',
                'completed_on'      => '22 Oct 2026',
                'photos'            => [
                    'https://images.unsplash.com/photo-1524178232363-1fb2b075b655?w=300&auto=format&fit=crop&q=80',
                    'https://images.unsplash.com/photo-1580582932707-520aed937b7b?w=300&auto=format&fit=crop&q=80',
                    'https://images.unsplash.com/photo-1577896851231-70ef18881754?w=300&auto=format&fit=crop&q=80',
                ],
                'date_formatted'    => '22 Oct 2026',
                'time_formatted'    => '09:45 AM',
                'status'            => 'Approved',
                'helpful_upvotes'   => 19,
                'helpful_downvotes' => 0,
                'admin_notes'       => 'Verified physical student enrollment.',
                'is_featured'       => true,
            ],
            [
                'id'                => 6,
                'user_name'         => 'Riya Desai',
                'user_email'        => 'riya.desai@mail.com',
                'user_city'         => 'Surat, Gujarat',
                'user_avatar'       => 'https://images.unsplash.com/photo-1534528741775-53994a69daeb?w=100&auto=format&fit=crop&q=80',
                'rating'            => 3.0,
                'review_text'       => 'Course content is good but needs more practical exercises and live code walkthroughs.',
                'review_type'       => 'Course',
                'item_title'        => 'Full Stack Web Development',
                'item_thumbnail'    => 'https://images.unsplash.com/photo-1517694712202-14dd9538aa97?w=120&auto=format&fit=crop&q=80',
                'seller_name'       => 'Creative Minds',
                'category'          => 'Development',
                'order_id'          => 'ORD001235',
                'enrolled_on'       => '15 Oct 2026',
                'completed_on'      => '21 Oct 2026',
                'photos'            => [],
                'date_formatted'    => '21 Oct 2026',
                'time_formatted'    => '01:20 PM',
                'status'            => 'Approved',
                'helpful_upvotes'   => 5,
                'helpful_downvotes' => 1,
                'admin_notes'       => null,
                'is_featured'       => false,
            ],
            [
                'id'                => 7,
                'user_name'         => 'Manish Joshi',
                'user_email'        => 'manish.joshi@mail.com',
                'user_city'         => 'Ahmedabad, Gujarat',
                'user_avatar'       => 'https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?w=100&auto=format&fit=crop&q=80',
                'rating'            => 5.0,
                'review_text'       => 'Amazing experience! Faculty is very helpful and provided valuable career roadmap.',
                'review_type'       => 'Course',
                'item_title'        => 'AI Tools for Business',
                'item_thumbnail'    => 'https://images.unsplash.com/photo-1677442136019-21780efad99a?w=120&auto=format&fit=crop&q=80',
                'seller_name'       => 'Rahul Digital',
                'category'          => 'AI & Tools',
                'order_id'          => 'ORD001233',
                'enrolled_on'       => '14 Oct 2026',
                'completed_on'      => '20 Oct 2026',
                'photos'            => [],
                'date_formatted'    => '20 Oct 2026',
                'time_formatted'    => '03:18 PM',
                'status'            => 'Flagged',
                'helpful_upvotes'   => 1,
                'helpful_downvotes' => 6,
                'admin_notes'       => 'Reported by community for repetitive promotion text. Pending moderation review.',
                'is_featured'       => false,
            ],
            [
                'id'                => 8,
                'user_name'         => 'Suresh Yadav',
                'user_email'        => 'suresh.yadav@mail.com',
                'user_city'         => 'Mumbai, Maharashtra',
                'user_avatar'       => 'https://images.unsplash.com/photo-1500648767791-00dcc994a43e?w=100&auto=format&fit=crop&q=80',
                'rating'            => 4.0,
                'review_text'       => 'Great product, value for money. Camera lenses work great and pictures are crisp.',
                'review_type'       => 'Product',
                'item_title'        => 'Canon DSLR Camera',
                'item_thumbnail'    => 'https://images.unsplash.com/photo-1516035069371-29a1b244cc32?w=120&auto=format&fit=crop&q=80',
                'seller_name'       => 'PhotoGear',
                'category'          => 'Camera',
                'order_id'          => 'ORD001230',
                'enrolled_on'       => '12 Oct 2026',
                'completed_on'      => '19 Oct 2026',
                'photos'            => [
                    'https://images.unsplash.com/photo-1516035069371-29a1b244cc32?w=300&auto=format&fit=crop&q=80',
                    'https://images.unsplash.com/photo-1502920917128-1aa500764cbd?w=300&auto=format&fit=crop&q=80',
                ],
                'date_formatted'    => '19 Oct 2026',
                'time_formatted'    => '05:40 PM',
                'status'            => 'Approved',
                'helpful_upvotes'   => 14,
                'helpful_downvotes' => 1,
                'admin_notes'       => null,
                'is_featured'       => false,
            ],
            [
                'id'                => 9,
                'user_name'         => 'Hetal Parmar',
                'user_email'        => 'hetal.parmar@mail.com',
                'user_city'         => 'Ahmedabad, Gujarat',
                'user_avatar'       => 'https://images.unsplash.com/photo-1573496359142-b8d87734a5a2?w=100&auto=format&fit=crop&q=80',
                'rating'            => 2.0,
                'review_text'       => 'Payment issue, still not resolved. Need urgent update on license key delivery.',
                'review_type'       => 'Service',
                'item_title'        => 'Tally Prime (1 Year)',
                'item_thumbnail'    => 'https://images.unsplash.com/photo-1554224155-8d04cb21cd6c?w=120&auto=format&fit=crop&q=80',
                'seller_name'       => 'VCEC Store',
                'category'          => 'Software',
                'order_id'          => 'ORD001228',
                'enrolled_on'       => '11 Oct 2026',
                'completed_on'      => '18 Oct 2026',
                'photos'            => [],
                'date_formatted'    => '18 Oct 2026',
                'time_formatted'    => '11:22 AM',
                'status'            => 'Pending',
                'helpful_upvotes'   => 2,
                'helpful_downvotes' => 3,
                'admin_notes'       => 'Seller assigned to resend activation email.',
                'is_featured'       => false,
            ],
            [
                'id'                => 10,
                'user_name'         => 'Imran Shaikh',
                'user_email'        => 'imran.shaikh@mail.com',
                'user_city'         => 'Surat, Gujarat',
                'user_avatar'       => 'https://images.unsplash.com/photo-1522075469751-3a6694fb2f61?w=100&auto=format&fit=crop&q=80',
                'rating'            => 4.0,
                'review_text'       => 'Good platform for learning. Recommended for spoken skills improvement.',
                'review_type'       => 'Course',
                'item_title'        => 'Spoken English Course',
                'item_thumbnail'    => 'https://images.unsplash.com/photo-1577896851231-70ef18881754?w=120&auto=format&fit=crop&q=80',
                'seller_name'       => 'Creative Minds',
                'category'          => 'Language',
                'order_id'          => 'ORD001225',
                'enrolled_on'       => '10 Oct 2026',
                'completed_on'      => '17 Oct 2026',
                'photos'            => [],
                'date_formatted'    => '17 Oct 2026',
                'time_formatted'    => '04:30 PM',
                'status'            => 'Approved',
                'helpful_upvotes'   => 7,
                'helpful_downvotes' => 0,
                'admin_notes'       => null,
                'is_featured'       => false,
            ],
        ];
    }
}

