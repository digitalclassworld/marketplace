<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\WebsitePage;
use Carbon\Carbon;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class AdminWebsiteController extends Controller
{
    /**
     * Display Website Management dashboard.
     */
    public function index(Request $request): View
    {
        $search = $request->query('search');
        $type = $request->query('type');
        $status = $request->query('status');
        $selectedId = $request->query('selected');

        $query = WebsitePage::query();

        if (!empty($search)) {
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('slug', 'like', "%{$search}%");
            });
        }

        if (!empty($type) && $type !== 'All Types') {
            $query->where('type', $type);
        }

        if (!empty($status) && $status !== 'All Status') {
            $query->where('status', $status);
        }

        if (empty($search) && empty($type) && empty($status)) {
            $pages = $query->orderBy('id', 'asc')->paginate(10)->withQueryString();
        } else {
            $pages = $query->latest('id')->paginate(10)->withQueryString();
        }

        $selectedPage = null;
        if (!empty($selectedId)) {
            $selectedPage = WebsitePage::find($selectedId);
        }
        if (!$selectedPage) {
            $selectedPage = WebsitePage::where('slug', '/')->first() ?? WebsitePage::first();
        }

        $kpi = [
            'total_pages'        => '28',
            'pages_growth'       => '+12%',
            'pages_sub'          => '+3 this month',
            'total_banners'      => '12',
            'banners_growth'     => '+20%',
            'banners_sub'        => '+2 this month',
            'active_menus'       => '8',
            'menus_growth'       => '100%',
            'menus_sub'          => 'All menus active',
            'website_status'     => 'Live',
            'status_sub'         => 'Last updated: 28 Oct 2026',
        ];

        return view('admin.website.index', [
            'pages'        => $pages,
            'selectedPage' => $selectedPage,
            'search'       => $search,
            'type'         => $type,
            'status'       => $status,
            'kpi'          => $kpi,
        ]);
    }

    /**
     * Store a new website page.
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'title'        => 'required|string|max:100',
            'slug'         => 'required|string|max:100',
            'type'         => 'required|string',
            'status'       => 'required|string',
            'show_in_menu' => 'nullable|boolean',
            'is_homepage'  => 'nullable|boolean',
        ]);

        $page = WebsitePage::create([
            'title'            => $validated['title'],
            'slug'             => str_starts_with($validated['slug'], '/') ? $validated['slug'] : '/' . $validated['slug'],
            'type'             => $validated['type'],
            'status'           => $validated['status'],
            'show_in_menu'     => $request->boolean('show_in_menu'),
            'is_homepage'      => $request->boolean('is_homepage'),
            'thumbnail'        => 'https://images.unsplash.com/photo-1516321318423-f06f85e504b3?auto=format&fit=crop&w=150&q=80',
            'last_updated_at'  => Carbon::now(),
        ]);

        return redirect()->route('admin.website.index', ['selected' => $page->id])
            ->with('success', "Page '{$page->title}' created successfully!");
    }

    /**
     * Update page settings.
     */
    public function update(Request $request, int $id): RedirectResponse
    {
        $page = WebsitePage::findOrFail($id);

        $validated = $request->validate([
            'title'            => 'required|string|max:100',
            'slug'             => 'required|string|max:100',
            'type'             => 'required|string',
            'status'           => 'required|string',
            'show_in_menu'     => 'nullable|boolean',
            'is_homepage'      => 'nullable|boolean',
            'meta_title'       => 'nullable|string|max:150',
            'meta_description' => 'nullable|string|max:300',
            'focus_keyword'    => 'nullable|string|max:100',
        ]);

        $page->title = $validated['title'];
        $page->slug = str_starts_with($validated['slug'], '/') ? $validated['slug'] : '/' . $validated['slug'];
        $page->type = $validated['type'];
        $page->status = $validated['status'];
        $page->show_in_menu = $request->boolean('show_in_menu');
        $page->is_homepage = $request->boolean('is_homepage');
        $page->meta_title = $request->input('meta_title');
        $page->meta_description = $request->input('meta_description');
        $page->focus_keyword = $request->input('focus_keyword');
        $page->last_updated_at = Carbon::now();
        $page->save();

        return redirect()->route('admin.website.index', ['selected' => $page->id])
            ->with('success', "Page '{$page->title}' settings updated successfully!");
    }

    /**
     * Duplicate a page.
     */
    public function duplicate(int $id): RedirectResponse
    {
        $page = WebsitePage::findOrFail($id);

        $clone = $page->replicate();
        $clone->title = $page->title . ' (Copy)';
        $clone->slug = $page->slug . '-copy';
        $clone->status = 'Draft';
        $clone->last_updated_at = Carbon::now();
        $clone->save();

        return redirect()->route('admin.website.index', ['selected' => $clone->id])
            ->with('success', "Page '{$page->title}' duplicated successfully!");
    }

    /**
     * Delete page.
     */
    public function destroy(int $id): RedirectResponse
    {
        $page = WebsitePage::findOrFail($id);
        $title = $page->title;
        $page->delete();

        return redirect()->route('admin.website.index')
            ->with('success', "Page '{$title}' deleted successfully!");
    }
}

