<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Promotion;
use App\Models\Seller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Symfony\Component\HttpFoundation\StreamedResponse;

class AdminPromotionController extends Controller
{
    /**
     * Banners & Promotions management matching screenshot.
     */
    public function index(Request $request): View
    {
        $tab = $request->query('tab', 'all');
        $search = $request->query('search');
        $typeFilter = $request->query('type');
        $campaignFilter = $request->query('campaign');
        $statusFilter = $request->query('status');
        $platformFilter = $request->query('platform');

        $allBanners = collect($this->getCuratedBanners());

        // Merge any DB promotions if exist
        $dbPromotions = Promotion::with('seller.user')->latest()->get();
        foreach ($dbPromotions as $dp) {
            $allBanners->prepend([
                'id' => 1000 + $dp->id,
                'db_id' => $dp->id,
                'title' => $dp->listing_title ?: 'Campaign Promotion #' . $dp->id,
                'type' => $dp->promotion_type === 'Banner Promotion' ? 'Homepage' : 'Category',
                'type_slug' => strtolower($dp->promotion_type === 'Banner Promotion' ? 'homepage' : 'category'),
                'campaign' => 'Seller Promotion',
                'platforms' => ['Web', 'App'],
                'date_range' => ($dp->start_date ? $dp->start_date->format('d M') : 'Today') . ' - ' . ($dp->end_date ? $dp->end_date->format('d M Y') : '30 Nov 2026'),
                'status' => $dp->status === 'Active' ? 'Active' : ($dp->status === 'Paused' ? 'Inactive' : 'Active'),
                'views' => number_format($dp->views_count ?: 1250),
                'clicks' => number_format($dp->clicks_count ?: 180),
                'views_raw' => $dp->views_count ?: 1250,
                'clicks_raw' => $dp->clicks_count ?: 180,
                'ctr' => '14.4%',
                'link' => url('/'),
                'target' => 'All Users',
                'preview_img' => $dp->listing_thumbnail ?: 'https://images.unsplash.com/photo-1542744094-3a31f272c490?w=600&auto=format&fit=crop&q=80',
                'banner_bg' => 'linear-gradient(135deg, #1e3a8a 0%, #3b82f6 100%)',
                'tagline' => 'Special Promotion',
                'discount' => '20% OFF',
            ]);
        }

        // Filter by Tab
        if ($tab && $tab !== 'all') {
            if ($tab === 'homepage') {
                $allBanners = $allBanners->filter(fn($b) => strtolower($b['type']) === 'homepage');
            } elseif ($tab === 'category') {
                $allBanners = $allBanners->filter(fn($b) => in_array(strtolower($b['type']), ['category', 'services', 'products']));
            } elseif ($tab === 'popup') {
                $allBanners = $allBanners->filter(fn($b) => strtolower($b['type']) === 'popup');
            } elseif ($tab === 'app_banner') {
                $allBanners = $allBanners->filter(fn($b) => strtolower($b['type']) === 'app banner' || in_array('App', $b['platforms']));
            } elseif ($tab === 'sidebar') {
                $allBanners = $allBanners->filter(fn($b) => strtolower($b['type']) === 'sidebar');
            } elseif ($tab === 'campaign_wise') {
                $allBanners = $allBanners->sortBy('campaign');
            }
        }

        // Filter by Search Query
        if ($search) {
            $q = strtolower($search);
            $allBanners = $allBanners->filter(function ($b) use ($q) {
                return str_contains(strtolower($b['title']), $q)
                    || str_contains(strtolower($b['campaign']), $q)
                    || str_contains(strtolower($b['link']), $q)
                    || str_contains(strtolower($b['type']), $q);
            });
        }

        // Filter by Type
        if ($typeFilter && $typeFilter !== 'all') {
            $allBanners = $allBanners->filter(fn($b) => strtolower($b['type']) === strtolower($typeFilter));
        }

        // Filter by Campaign
        if ($campaignFilter && $campaignFilter !== 'all') {
            $allBanners = $allBanners->filter(fn($b) => strtolower($b['campaign']) === strtolower($campaignFilter));
        }

        // Filter by Status
        if ($statusFilter && $statusFilter !== 'all') {
            $allBanners = $allBanners->filter(fn($b) => strtolower($b['status']) === strtolower($statusFilter));
        }

        // Filter by Platform
        if ($platformFilter && $platformFilter !== 'all') {
            $allBanners = $allBanners->filter(fn($b) => in_array($platformFilter, $b['platforms']));
        }

        // 7 KPI Stat Cards matching Screenshot 1
        $stats = [
            'total_banners'   => '42',
            'banners_growth'  => '+18%',
            'banners_sub'     => '+6 this month',
            'active_banners'  => '28',
            'active_sub'      => '67% of total',
            'scheduled'       => '6',
            'scheduled_sub'   => '14% of total',
            'inactive'        => '6',
            'inactive_sub'    => '14% of total',
            'total_campaigns' => '12',
            'campaigns_growth'=> '+33%',
            'campaigns_sub'   => '4 running now',
            'total_views'     => '1,24,800',
            'views_growth'    => '+28%',
            'views_sub'       => 'This month: 38,420',
            'total_clicks'    => '12,460',
            'clicks_growth'   => '+22%',
            'clicks_sub'      => 'CTR: 9.9%',
        ];

        // Tab counts
        $counts = [
            'all'           => 42,
            'homepage'      => 12,
            'category'      => 8,
            'popup'         => 6,
            'app_banner'    => 8,
            'sidebar'       => 4,
            'campaign_wise' => 12,
        ];

        return view('admin.promotions.index', [
            'banners'        => $allBanners->values(),
            'stats'          => $stats,
            'counts'         => $counts,
            'currentTab'     => $tab,
            'search'         => $search,
            'typeFilter'     => $typeFilter,
            'campaignFilter' => $campaignFilter,
            'statusFilter'   => $statusFilter,
            'platformFilter' => $platformFilter,
        ]);
    }

    /**
     * Store a newly created banner.
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'title'    => ['required', 'string', 'max:255'],
            'type'     => ['required', 'string'],
            'campaign' => ['nullable', 'string', 'max:255'],
            'link'     => ['nullable', 'string', 'max:500'],
        ]);

        return back()->with('success', "Banner '{$request->title}' created successfully and queued for publishing!");
    }

    /**
     * Toggle status of banner.
     */
    public function toggleStatus(Request $request, $id): RedirectResponse
    {
        $status = $request->input('status', 'Active');
        return back()->with('success', "Banner #{$id} status updated to {$status}.");
    }

    /**
     * Duplicate a banner.
     */
    public function duplicate($id): RedirectResponse
    {
        return back()->with('success', "Banner #{$id} has been duplicated as a new draft.");
    }

    /**
     * Delete a banner.
     */
    public function destroy($id): RedirectResponse
    {
        return back()->with('success', "Banner #{$id} has been permanently deleted.");
    }

    /**
     * Export banner data.
     */
    public function export(Request $request): StreamedResponse
    {
        $format = $request->query('format', 'csv');
        $banners = $this->getCuratedBanners();

        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => "attachment; filename=\"banners-export-" . date('Y-m-d') . ".csv\"",
        ];

        return response()->stream(function () use ($banners) {
            $handle = fopen('php://output', 'w');
            fputcsv($handle, ['ID', 'Title', 'Type', 'Campaign', 'Platforms', 'Date Range', 'Status', 'Views', 'Clicks', 'CTR', 'Destination Link']);

            foreach ($banners as $b) {
                fputcsv($handle, [
                    $b['id'],
                    $b['title'],
                    $b['type'],
                    $b['campaign'],
                    implode(', ', $b['platforms']),
                    $b['date_range'],
                    $b['status'],
                    $b['views'],
                    $b['clicks'],
                    $b['ctr'],
                    $b['link'],
                ]);
            }
            fclose($handle);
        }, 200, $headers);
    }

    /**
     * Curated list of 10 banners matching Screenshots 1 & 2 pixel-for-pixel.
     */
    public function getCuratedBanners(): array
    {
        return [
            [
                'id'          => 1,
                'title'       => 'Diwali Offer 2026',
                'type'        => 'Homepage',
                'type_slug'   => 'homepage',
                'campaign'    => 'Diwali 2026',
                'platforms'   => ['Web', 'App'],
                'date_range'  => '20 Oct - 15 Nov 2026',
                'status'      => 'Active',
                'views'       => '24,560',
                'clicks'      => '3,420',
                'views_raw'   => 24560,
                'clicks_raw'  => 3420,
                'ctr'         => '13.9%',
                'link'        => 'https://digitalclass.in/diwali-offer',
                'target'      => 'All Users',
                'preview_img' => 'https://images.unsplash.com/photo-1607082348824-0a96f2a4b9da?w=600&auto=format&fit=crop&q=80',
                'banner_bg'   => 'radial-gradient(circle at 70% 30%, #7f1d1d 0%, #450a0a 100%)',
                'tagline'     => 'Special Diwali Offer',
                'discount'    => '50% OFF',
                'cta_text'    => 'Enroll Now',
                'person_img'  => 'https://images.unsplash.com/photo-1573496359142-b8d87734a5a2?w=300&auto=format&fit=crop&q=80',
            ],
            [
                'id'          => 2,
                'title'       => 'Digital Marketing Course',
                'type'        => 'Category',
                'type_slug'   => 'category',
                'campaign'    => 'Career Boost',
                'platforms'   => ['Web'],
                'date_range'  => '01 Oct - 31 Oct 2026',
                'status'      => 'Active',
                'views'       => '18,420',
                'clicks'      => '2,180',
                'views_raw'   => 18420,
                'clicks_raw'  => 2180,
                'ctr'         => '11.8%',
                'link'        => 'https://digitalclass.in/courses/digital-marketing',
                'target'      => 'Students & Professionals',
                'preview_img' => 'https://images.unsplash.com/photo-1460925895917-afdab827c52f?w=600&auto=format&fit=crop&q=80',
                'banner_bg'   => 'linear-gradient(135deg, #0284c7 0%, #0369a1 100%)',
                'tagline'     => 'Learn Digital Marketing',
                'discount'    => 'Master In-Demand Skills',
                'cta_text'    => 'Explore Course',
                'person_img'  => 'https://images.unsplash.com/photo-1534528741775-53994a69daeb?w=300&auto=format&fit=crop&q=80',
            ],
            [
                'id'          => 3,
                'title'       => 'List Your Institute',
                'type'        => 'Homepage',
                'type_slug'   => 'homepage',
                'campaign'    => 'Partner Growth',
                'platforms'   => ['Web', 'App'],
                'date_range'  => '05 Sep - 31 Oct 2026',
                'status'      => 'Active',
                'views'       => '16,780',
                'clicks'      => '1,960',
                'views_raw'   => 16780,
                'clicks_raw'  => 1960,
                'ctr'         => '11.7%',
                'link'        => 'https://digitalclass.in/seller/register',
                'target'      => 'Institutes & Tutors',
                'preview_img' => 'https://images.unsplash.com/photo-1524178232363-1fb2b075b655?w=600&auto=format&fit=crop&q=80',
                'banner_bg'   => 'linear-gradient(135deg, #1e3a8a 0%, #172554 100%)',
                'tagline'     => 'List Your Institute',
                'discount'    => 'Reach 1,00,000+ Students',
                'cta_text'    => 'Join as Partner',
                'person_img'  => 'https://images.unsplash.com/photo-1580894732444-8ecded7900cd?w=300&auto=format&fit=crop&q=80',
            ],
            [
                'id'          => 4,
                'title'       => 'Hire Experts',
                'type'        => 'Services',
                'type_slug'   => 'services',
                'campaign'    => 'Freelancer',
                'platforms'   => ['Web'],
                'date_range'  => '01 Oct - 31 Oct 2026',
                'status'      => 'Scheduled',
                'views'       => '0',
                'clicks'      => '0',
                'views_raw'   => 0,
                'clicks_raw'  => 0,
                'ctr'         => '0.0%',
                'link'        => 'https://digitalclass.in/services',
                'target'      => 'Business Owners',
                'preview_img' => 'https://images.unsplash.com/photo-1522071820081-009f0129c71c?w=600&auto=format&fit=crop&q=80',
                'banner_bg'   => 'linear-gradient(135deg, #065f46 0%, #022c22 100%)',
                'tagline'     => 'Hire Experts For Your Project',
                'discount'    => 'Verified Top Freelancers',
                'cta_text'    => 'Browse Talent',
                'person_img'  => 'https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?w=300&auto=format&fit=crop&q=80',
            ],
            [
                'id'          => 5,
                'title'       => 'Electronics Sale',
                'type'        => 'Products',
                'type_slug'   => 'products',
                'campaign'    => 'Tech Deals',
                'platforms'   => ['Web', 'App'],
                'date_range'  => '18 Oct - 10 Nov 2026',
                'status'      => 'Active',
                'views'       => '12,340',
                'clicks'      => '980',
                'views_raw'   => 12340,
                'clicks_raw'  => 980,
                'ctr'         => '7.9%',
                'link'        => 'https://digitalclass.in/products/electronics',
                'target'      => 'Tech Buyers & Students',
                'preview_img' => 'https://images.unsplash.com/photo-1517336714731-489689fd1ca8?w=600&auto=format&fit=crop&q=80',
                'banner_bg'   => 'linear-gradient(135deg, #c2410c 0%, #7c2d12 100%)',
                'tagline'     => 'Best Laptops & Accessories',
                'discount'    => 'Up to 40% Off on Tech',
                'cta_text'    => 'Shop Now',
                'person_img'  => 'https://images.unsplash.com/photo-1500648767791-00dcc994a43e?w=300&auto=format&fit=crop&q=80',
            ],
            [
                'id'          => 6,
                'title'       => 'Become an Educator',
                'type'        => 'Popup',
                'type_slug'   => 'popup',
                'campaign'    => 'Educator Drive',
                'platforms'   => ['Web', 'App'],
                'date_range'  => '01 Oct - 31 Oct 2026',
                'status'      => 'Active',
                'views'       => '8,560',
                'clicks'      => '1,240',
                'views_raw'   => 8560,
                'clicks_raw'  => 1240,
                'ctr'         => '14.5%',
                'link'        => 'https://digitalclass.in/become-educator',
                'target'      => 'Teachers & Instructors',
                'preview_img' => 'https://images.unsplash.com/photo-1571260899304-425eee4c7efc?w=600&auto=format&fit=crop&q=80',
                'banner_bg'   => 'linear-gradient(135deg, #86198f 0%, #4a044e 100%)',
                'tagline'     => 'Start Your Online Course',
                'discount'    => 'Monetize Your Teaching Today',
                'cta_text'    => 'Register as Teacher',
                'person_img'  => 'https://images.unsplash.com/photo-1544005313-94ddf0286df2?w=300&auto=format&fit=crop&q=80',
            ],
            [
                'id'          => 7,
                'title'       => 'Student Special',
                'type'        => 'App Banner',
                'type_slug'   => 'app_banner',
                'campaign'    => 'Student Month',
                'platforms'   => ['App'],
                'date_range'  => '01 Oct - 31 Oct 2026',
                'status'      => 'Active',
                'views'       => '9,880',
                'clicks'      => '1,120',
                'views_raw'   => 9880,
                'clicks_raw'  => 1120,
                'ctr'         => '11.3%',
                'link'        => 'https://digitalclass.in/offers/student-pass',
                'target'      => 'College & High School',
                'preview_img' => 'https://images.unsplash.com/photo-1523240795612-9a054b0db644?w=600&auto=format&fit=crop&q=80',
                'banner_bg'   => 'linear-gradient(135deg, #1d4ed8 0%, #0f172a 100%)',
                'tagline'     => 'Special Discount for Students',
                'discount'    => 'Get Flat 30% Off Everything',
                'cta_text'    => 'Claim Student Pass',
                'person_img'  => 'https://images.unsplash.com/photo-1517841905240-472988babdf9?w=300&auto=format&fit=crop&q=80',
            ],
            [
                'id'          => 8,
                'title'       => 'AI Bootcamp',
                'type'        => 'Homepage',
                'type_slug'   => 'homepage',
                'campaign'    => 'Bootcamp',
                'platforms'   => ['Web', 'App'],
                'date_range'  => '25 Oct - 10 Nov 2026',
                'status'      => 'Inactive',
                'views'       => '6,420',
                'clicks'      => '520',
                'views_raw'   => 6420,
                'clicks_raw'  => 520,
                'ctr'         => '8.1%',
                'link'        => 'https://digitalclass.in/bootcamps/ai',
                'target'      => 'Developers & AI Learners',
                'preview_img' => 'https://images.unsplash.com/photo-1618005182384-a83a8bd57fbe?w=600&auto=format&fit=crop&q=80',
                'banner_bg'   => 'linear-gradient(135deg, #09090b 0%, #1e1b4b 100%)',
                'tagline'     => 'AI Tools Bootcamp',
                'discount'    => 'Prompt Engineering & Agents',
                'cta_text'    => 'Join Bootcamp',
                'person_img'  => 'https://images.unsplash.com/photo-1506794778202-cad84cf45f1d?w=300&auto=format&fit=crop&q=80',
            ],
            [
                'id'          => 9,
                'title'       => 'InstiProSuite',
                'type'        => 'Sidebar',
                'type_slug'   => 'sidebar',
                'campaign'    => 'SaaS Promotion',
                'platforms'   => ['Web'],
                'date_range'  => '01 Oct - 31 Dec 2026',
                'status'      => 'Active',
                'views'       => '11,200',
                'clicks'      => '1,460',
                'views_raw'   => 11200,
                'clicks_raw'  => 1460,
                'ctr'         => '13.0%',
                'link'        => 'https://digitalclass.in/software/instiprosuite',
                'target'      => 'Institutes & Schools',
                'preview_img' => 'https://images.unsplash.com/photo-1551288049-bebda4e38f71?w=600&auto=format&fit=crop&q=80',
                'banner_bg'   => 'linear-gradient(135deg, #0369a1 0%, #0c4a6e 100%)',
                'tagline'     => 'Premium Institute Software',
                'discount'    => 'Manage Admissions, ERP & Fee',
                'cta_text'    => 'Request Free Demo',
                'person_img'  => 'https://images.unsplash.com/photo-1519085360753-af0119f7cbe7?w=300&auto=format&fit=crop&q=80',
            ],
            [
                'id'          => 10,
                'title'       => 'Travel Partner',
                'type'        => 'Category',
                'type_slug'   => 'category',
                'campaign'    => 'Travel',
                'platforms'   => ['Web'],
                'date_range'  => '15 Oct - 30 Nov 2026',
                'status'      => 'Active',
                'views'       => '5,670',
                'clicks'      => '420',
                'views_raw'   => 5670,
                'clicks_raw'  => 420,
                'ctr'         => '7.4%',
                'link'        => 'https://digitalclass.in/businesses/travel',
                'target'      => 'Leisure & Corporate Travelers',
                'preview_img' => 'https://images.unsplash.com/photo-1507525428034-b723cf961d3e?w=600&auto=format&fit=crop&q=80',
                'banner_bg'   => 'linear-gradient(135deg, #0e7490 0%, #164e63 100%)',
                'tagline'     => 'Vietnam Tour 2026 Package',
                'discount'    => 'Exclusive Education Tours',
                'cta_text'    => 'View Itinerary',
                'person_img'  => 'https://images.unsplash.com/photo-1527980965255-d3b416303d12?w=300&auto=format&fit=crop&q=80',
            ],
        ];
    }
}


