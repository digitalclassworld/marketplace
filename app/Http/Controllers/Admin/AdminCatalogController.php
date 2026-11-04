<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\BusinessListing;
use App\Models\Course;
use App\Models\Product;
use App\Models\Service;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class AdminCatalogController extends Controller
{
    // ==========================================
    // 1. COURSES
    // ==========================================
    public function courses(Request $request): View
    {
        $status = $request->query('status');
        $query = Course::with(['seller.businessDetail', 'seller.user', 'contents'])->latest();

        if ($status && in_array($status, ['pending', 'approved', 'rejected'])) {
            $query->where('status', $status);
        }

        $courses = $query->paginate(15);
        $counts = [
            'all'      => Course::count(),
            'pending'  => Course::where('status', 'pending')->count(),
            'approved' => Course::where('status', 'approved')->count(),
            'rejected' => Course::where('status', 'rejected')->count(),
        ];

        return view('admin.catalog.courses', compact('courses', 'counts', 'status'));
    }

    public function approveCourse(int $id): RedirectResponse
    {
        $course = Course::findOrFail($id);
        $course->update([
            'status'           => 'approved',
            'rejection_reason' => null,
            'approved_at'      => now(),
            'approved_by'      => Auth::id(),
        ]);

        return back()->with('success', "Course '{$course->title}' approved successfully and published to marketplace!");
    }

    public function rejectCourse(Request $request, int $id): RedirectResponse
    {
        $course = Course::findOrFail($id);
        $reason = $request->input('reason', 'Does not meet marketplace quality guidelines.');

        $course->update([
            'status'           => 'rejected',
            'rejection_reason' => $reason,
        ]);

        return back()->with('success', "Course '{$course->title}' has been marked as rejected.");
    }

    // ==========================================
    // 2. SERVICES
    // ==========================================
    public function services(Request $request): View
    {
        $status = $request->query('status');
        $query = Service::with('seller.businessDetail')->latest();

        if ($status && in_array($status, ['pending', 'approved', 'rejected'])) {
            $query->where('status', $status);
        }

        $services = $query->paginate(15);
        $counts = [
            'all'      => Service::count(),
            'pending'  => Service::where('status', 'pending')->count(),
            'approved' => Service::where('status', 'approved')->count(),
            'rejected' => Service::where('status', 'rejected')->count(),
        ];

        return view('admin.catalog.services', compact('services', 'counts', 'status'));
    }

    public function approveService(int $id): RedirectResponse
    {
        $service = Service::findOrFail($id);
        $service->update([
            'status'           => 'approved',
            'rejection_reason' => null,
            'approved_at'      => now(),
            'approved_by'      => Auth::id(),
        ]);

        return back()->with('success', "Service gig '{$service->title}' approved successfully!");
    }

    public function rejectService(Request $request, int $id): RedirectResponse
    {
        $service = Service::findOrFail($id);
        $reason = $request->input('reason', 'Service terms do not comply with platform standards.');

        $service->update([
            'status'           => 'rejected',
            'rejection_reason' => $reason,
        ]);

        return back()->with('success', "Service gig '{$service->title}' has been marked as rejected.");
    }

    // ==========================================
    // 3. PRODUCTS
    // ==========================================
    public function products(Request $request): View
    {
        $status = $request->query('status');
        $query = Product::with('seller.businessDetail')->latest();

        if ($status && in_array($status, ['pending', 'approved', 'rejected'])) {
            $query->where('status', $status);
        }

        $products = $query->paginate(15);
        $counts = [
            'all'      => Product::count(),
            'pending'  => Product::where('status', 'pending')->count(),
            'approved' => Product::where('status', 'approved')->count(),
            'rejected' => Product::where('status', 'rejected')->count(),
        ];

        return view('admin.catalog.products', compact('products', 'counts', 'status'));
    }

    public function approveProduct(int $id): RedirectResponse
    {
        $product = Product::findOrFail($id);
        $product->update([
            'status'           => 'approved',
            'rejection_reason' => null,
            'approved_at'      => now(),
            'approved_by'      => Auth::id(),
        ]);

        return back()->with('success', "Product '{$product->title}' approved successfully!");
    }

    public function rejectProduct(Request $request, int $id): RedirectResponse
    {
        $product = Product::findOrFail($id);
        $reason = $request->input('reason', 'Product information is incomplete or rejected.');

        $product->update([
            'status'           => 'rejected',
            'rejection_reason' => $reason,
        ]);

        return back()->with('success', "Product '{$product->title}' has been rejected.");
    }

    // ==========================================
    // 4. BUSINESS DIRECTORY LISTINGS
    // ==========================================
    public function listings(Request $request): View
    {
        $status = $request->query('status');
        $query = BusinessListing::with('seller.businessDetail')->latest();

        if ($status && in_array($status, ['pending', 'approved', 'rejected'])) {
            $query->where('status', $status);
        }

        $listings = $query->paginate(15);
        $counts = [
            'all'      => BusinessListing::count(),
            'pending'  => BusinessListing::where('status', 'pending')->count(),
            'approved' => BusinessListing::where('status', 'approved')->count(),
            'rejected' => BusinessListing::where('status', 'rejected')->count(),
        ];

        return view('admin.catalog.listings', compact('listings', 'counts', 'status'));
    }

    public function approveListing(int $id): RedirectResponse
    {
        $listing = BusinessListing::findOrFail($id);
        $listing->update([
            'status'           => 'approved',
            'rejection_reason' => null,
            'approved_at'      => now(),
            'approved_by'      => Auth::id(),
        ]);

        return back()->with('success', "Business listing '{$listing->business_name}' approved and listed!");
    }

    public function rejectListing(Request $request, int $id): RedirectResponse
    {
        $listing = BusinessListing::findOrFail($id);
        $reason = $request->input('reason', 'Business details could not be verified.');

        $listing->update([
            'status'           => 'rejected',
            'rejection_reason' => $reason,
        ]);

        return back()->with('success', "Business listing '{$listing->business_name}' has been rejected.");
    }
}

