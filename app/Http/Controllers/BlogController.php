<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\PageSeo;
use Illuminate\Http\Request;

class BlogController extends Controller
{
    public function index()
    {
        $posts = Post::where('is_published', true)
            ->latest()
            ->paginate(12);
        
        // Get SEO for blog listing page
        $pageSeo = PageSeo::where('page_type', 'static')
            ->where('slug', 'blog')
            ->first();
            
        return view('blog.index', compact('posts', 'pageSeo'));
    }

    public function show(Post $post)
    {
        if (!$post->is_published) {
            abort(404);
        }
        
        // Get SEO for this specific post
        $pageSeo = PageSeo::where('page_type', 'post')
            ->where('page_id', $post->id)
            ->first();
        
        $relatedPosts = Post::where('is_published', true)
            ->where('id', '!=', $post->id)
            ->latest()
            ->limit(7)
            ->get();
            
        return view('blog.show', compact('post', 'relatedPosts', 'pageSeo'));
    }
}