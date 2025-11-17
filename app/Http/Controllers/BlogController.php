<?php

namespace App\Http\Controllers;

use App\Models\BlogPost;
use Illuminate\Http\Request;

class BlogController extends Controller
{
    /**
     * Display blog posts listing
     */
    public function index(Request $request)
    {
        $query = BlogPost::with('author')->published()->latest('published_at');

        // Filter by category
        if ($request->has('category') && $request->category) {
            $query->category($request->category);
        }

        // Search
        if ($request->has('search') && $request->search) {
            $query->where(function($q) use ($request) {
                $q->where('title', 'like', "%{$request->search}%")
                  ->orWhere('excerpt', 'like', "%{$request->search}%")
                  ->orWhere('content', 'like', "%{$request->search}%");
            });
        }

        $posts = $query->paginate(12);
        $categories = ['travel', 'tips', 'destinations', 'culture', 'food'];

        return view('blog.index', compact('posts', 'categories'));
    }

    /**
     * Display single blog post
     */
    public function show(string $slug)
    {
        $post = BlogPost::with('author')->where('slug', $slug)->published()->firstOrFail();

        // Increment views
        $post->incrementViews();

        // Get related posts
        $relatedPosts = BlogPost::published()
            ->where('category', $post->category)
            ->where('id', '!=', $post->id)
            ->latest('published_at')
            ->take(3)
            ->get();

        return view('blog.show', compact('post', 'relatedPosts'));
    }
}
