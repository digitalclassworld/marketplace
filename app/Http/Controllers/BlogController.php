<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Post;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class BlogController extends Controller
{
    /**
     * Display public blog directory on the main marketplace website.
     */
    public function index(Request $request): View
    {
        $search = $request->query('search');
        $category = $request->query('category');
        $tag = $request->query('tag');

        $query = Post::where('status', 'Published')->latest('published_at');

        if (!empty($search)) {
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('excerpt', 'like', "%{$search}%")
                  ->orWhere('content', 'like', "%{$search}%")
                  ->orWhere('author_name', 'like', "%{$search}%");
            });
        }

        if (!empty($category) && $category !== 'All') {
            $query->where('category', $category);
        }

        if (!empty($tag)) {
            $query->whereJsonContains('tags', $tag);
        }

        $posts = $query->paginate(9)->withQueryString();

        // Featured Hero Post
        $featuredPost = Post::where('status', 'Published')
            ->where('is_featured', true)
            ->latest('published_at')
            ->first() ?? Post::where('status', 'Published')->first();

        $categories = Category::all();
        $recentPosts = Post::where('status', 'Published')->latest('published_at')->take(4)->get();
        $popularPosts = Post::where('status', 'Published')->orderByDesc('views')->take(4)->get();

        return view('home.blog.index', [
            'posts'        => $posts,
            'featuredPost' => $featuredPost,
            'categories'   => $categories,
            'recentPosts'  => $recentPosts,
            'popularPosts' => $popularPosts,
            'search'       => $search,
            'selectedCat'  => $category,
        ]);
    }

    /**
     * Display individual blog post reader on the main website.
     */
    public function show(string $slug): View
    {
        $post = Post::with('comments')->where('slug', $slug)->firstOrFail();

        // Increment views count
        $post->increment('views');

        $relatedPosts = Post::where('status', 'Published')
            ->where('id', '!=', $post->id)
            ->where('category', $post->category)
            ->take(3)
            ->get();

        if ($relatedPosts->count() === 0) {
            $relatedPosts = Post::where('status', 'Published')
                ->where('id', '!=', $post->id)
                ->latest('published_at')
                ->take(3)
                ->get();
        }

        $categories = Category::all();

        return view('home.blog.show', [
            'post'         => $post,
            'relatedPosts' => $relatedPosts,
            'categories'   => $categories,
        ]);
    }

    /**
     * Post a comment on a public blog article.
     */
    public function comment(Request $request, string $slug): RedirectResponse
    {
        $request->validate([
            'name'    => 'required|string|max:100',
            'email'   => 'nullable|email|max:150',
            'comment' => 'required|string|max:1000',
        ]);

        $post = Post::where('slug', $slug)->firstOrFail();

        $post->comments()->create([
            'name'        => $request->input('name'),
            'email'       => $request->input('email'),
            'comment'     => $request->input('comment'),
            'is_approved' => true,
        ]);

        return back()->with('success', 'Thank you! Your comment has been posted successfully.');
    }
}
