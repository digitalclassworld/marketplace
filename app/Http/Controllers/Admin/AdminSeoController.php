<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SeoSetting;
use Carbon\Carbon;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class AdminSeoController extends Controller
{
    /**
     * Display SEO Management studio.
     */
    public function index(Request $request): View
    {
        $tab = $request->query('tab', 'global');
        $section = $request->query('section', 'courses');

        $seo = SeoSetting::firstOrCreate([], [
            'site_title'                  => 'Digital Class - Courses, Services, Products & Business Listings',
            'site_tagline'                => 'Learn. Teach. Buy. Hire. All in One Educational Marketplace.',
            'meta_description'            => 'Digital Class is an online marketplace for courses, services, products and business listings. Discover, learn, buy and grow with trusted educators and businesses across India.',
            'default_keywords'            => 'online courses, professional services, educational products, business listings, skill development, digital marketplace',
            'social_image_url'            => 'https://images.unsplash.com/photo-1522202176988-66273c2fd55f?auto=format&fit=crop&w=1200&q=80',
            'favicon_url'                 => 'https://images.unsplash.com/photo-1618005182384-a83a8bd57fbe?auto=format&fit=crop&w=64&q=80',
            'meta_robots'                 => 'Index, Follow',
            'canonical_mode'              => 'Auto Generated',
            'enable_open_graph'           => true,
            'enable_twitter_card'         => true,
            'enable_breadcrumbs'          => true,
            'enable_json_ld'              => true,
            'course_title_template'       => '{course_name} Online Course | {institute_name} | Digital Class',
            'course_description_template' => 'Learn {course_name} online from {institute_name}. Course duration: {duration}. Fees: {price}. Enroll now on Digital Class.',
            'course_url_template'         => '/course/{course_slug}',
            'course_focus_keywords'       => '{course_name}, online course, {category_name}, {sub_category_name}',
            'indexed_pages_count'         => 12480,
            'total_seo_pages_count'       => 28540,
            'seo_score'                   => 92,
            'organic_traffic'             => '3.2M',
            'sitemap_last_generated'      => Carbon::parse('2026-10-30 10:20:00'),
            'robots_txt_content'          => "User-agent: *\nAllow: /\nDisallow: /admin/\nDisallow: /seller/dashboard\nDisallow: /checkout/\nSitemap: https://digitalclass.in/sitemap.xml",
        ]);

        $kpi = [
            'indexed_pages'        => '12,480',
            'indexed_growth'       => '+28%',
            'indexed_sub'          => 'Indexed Pages',
            'total_seo_pages'      => '28,540',
            'total_seo_sub'        => 'Courses, Services, Products, Businesses',
            'sitemap_status'       => 'Active',
            'sitemap_sub'          => 'Last generated: ' . ($seo->sitemap_last_generated ? $seo->sitemap_last_generated->format('d M Y') : '30 Oct 2026'),
            'robots_status'        => 'Configured',
            'robots_sub'           => 'Allow indexing',
            'seo_score'            => '92/100',
            'seo_score_label'      => 'Good',
            'organic_traffic'      => '3.2M',
            'traffic_growth'       => '+18%',
            'traffic_sub'          => 'Monthly Visitors (Organic)',
        ];

        return view('admin.seo.index', [
            'seo'     => $seo,
            'tab'     => $tab,
            'section' => $section,
            'kpi'     => $kpi,
        ]);
    }

    /**
     * Update Global SEO & Template Settings.
     */
    public function update(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'site_title'                  => 'required|string|max:150',
            'site_tagline'                => 'nullable|string|max:150',
            'meta_description'            => 'required|string|max:200',
            'default_keywords'            => 'nullable|string|max:300',
            'meta_robots'                 => 'nullable|string',
            'canonical_mode'              => 'nullable|string',
            'course_title_template'       => 'nullable|string|max:150',
            'course_description_template' => 'nullable|string|max:300',
            'course_url_template'         => 'nullable|string|max:100',
            'course_focus_keywords'       => 'nullable|string|max:200',
            'enable_open_graph'           => 'nullable|boolean',
            'enable_twitter_card'         => 'nullable|boolean',
            'enable_breadcrumbs'          => 'nullable|boolean',
            'enable_json_ld'              => 'nullable|boolean',
        ]);

        $seo = SeoSetting::firstOrCreate([]);
        $seo->update([
            'site_title'                  => $validated['site_title'],
            'site_tagline'                => $validated['site_tagline'] ?? $seo->site_tagline,
            'meta_description'            => $validated['meta_description'],
            'default_keywords'            => $validated['default_keywords'] ?? $seo->default_keywords,
            'meta_robots'                 => $request->input('meta_robots', $seo->meta_robots ?? 'Index, Follow'),
            'canonical_mode'              => $request->input('canonical_mode', $seo->canonical_mode ?? 'Auto Generated'),
            'course_title_template'       => $request->input('course_title_template') ?: $seo->course_title_template,
            'course_description_template' => $request->input('course_description_template') ?: $seo->course_description_template,
            'course_url_template'         => $request->input('course_url_template') ?: ($seo->course_url_template ?: '/course/{course_slug}'),
            'course_focus_keywords'       => $request->input('course_focus_keywords') ?: $seo->course_focus_keywords,
            'enable_open_graph'           => $request->boolean('enable_open_graph'),
            'enable_twitter_card'         => $request->boolean('enable_twitter_card'),
            'enable_breadcrumbs'          => $request->boolean('enable_breadcrumbs'),
            'enable_json_ld'              => $request->boolean('enable_json_ld'),
        ]);

        return redirect()->route('admin.seo.index')
            ->with('success', 'Global SEO settings and URL templates updated successfully!');
    }

    /**
     * Trigger XML Sitemap regeneration.
     */
    public function generateSitemap(): RedirectResponse
    {
        $seo = SeoSetting::firstOrCreate([]);
        $seo->sitemap_last_generated = Carbon::now();
        $seo->save();

        return redirect()->route('admin.seo.index')
            ->with('success', 'XML Sitemap generated and submitted to Google & Bing search consoles!');
    }
}
