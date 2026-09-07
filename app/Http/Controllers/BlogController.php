<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\PageSeo;
use Illuminate\Http\Request;

class BlogController extends Controller
{
    public function index(Request $request, ?string $tag = null)
    {
        $currentTag = $tag ?? $request->query('tag');
        $query = Post::where('is_published', true);

        if ($currentTag) {
            $currentTag = trim($currentTag);
            $query->where(function ($q) use ($currentTag) {
                $q->whereJsonContains('tags', $currentTag)
                  ->orWhere('tags', 'LIKE', '%"' . $currentTag . '"%')
                  ->orWhere('tags', 'LIKE', '%' . $currentTag . '%');
            });
        }

        $posts = $query->latest()->paginate(12)->withQueryString();
        
        // Get SEO for blog listing page
        $pageSeo = PageSeo::where('page_type', 'static')
            ->where('slug', 'blog')
            ->first();
            
        return view('blog.index', compact('posts', 'pageSeo', 'currentTag'));
    }

    public function tag(Request $request, string $tag)
    {
        return $this->index($request, $tag);
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