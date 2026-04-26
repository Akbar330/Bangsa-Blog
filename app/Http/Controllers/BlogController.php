<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Category;
use App\Models\Tag;
use Illuminate\Http\Request;

class BlogController extends Controller
{
    /**
     * Homepage of the blog.
     */
    public function index()
    {
        $featuredPosts = Post::published()->where('is_featured', true)->latest()->take(3)->get();
        $latestPosts = Post::published()->with(['category', 'user'])->latest()->paginate(10);
        $popularPosts = Post::published()->trending()->take(5)->get();
        $categories = Category::withCount('posts')->get();

        return view('welcome', compact('featuredPosts', 'latestPosts', 'popularPosts', 'categories'));
    }

    /**
     * Display a single post.
     */
    public function show(Post $post)
    {
        // Don't allow viewing unpublished posts unless you are an editor/admin
        if ($post->status !== 'published' && (!auth()->check() || !auth()->user()->hasAnyRole(['admin', 'editor']))) {
            abort(404);
        }

        // Increment views count realistically
        $post->increment('views_count');
        
        $relatedPosts = Post::published()
            ->where('category_id', $post->category_id)
            ->where('id', '!=', $post->id)
            ->take(3)
            ->get();

        return view('posts.show', compact('post', 'relatedPosts'));
    }

    /**
     * Display posts by category.
     */
    public function category(Category $category)
    {
        $posts = $category->posts()->published()->latest()->paginate(10);
        return view('category', compact('category', 'posts'));
    }

    /**
     * Display posts by tag.
     */
    public function tag(Tag $tag)
    {
        $posts = $tag->posts()->published()->latest()->paginate(10);
        return view('tag', compact('tag', 'posts'));
    }

    /**
     * Search posts.
     */
    public function search(Request $request)
    {
        $query = $request->input('q');
        
        $posts = Post::published()
            ->where(function($q) use ($query) {
                $q->where('title', 'LIKE', "%{$query}%")
                  ->orWhere('content', 'LIKE', "%{$query}%");
            })
            ->latest()
            ->paginate(10);

        return view('search', compact('posts', 'query'));
    }
}
