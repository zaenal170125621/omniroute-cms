<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;

class PostController extends Controller
{
    public function index(Request $request)
    {
        $query = Post::published()->orderBy('published_at', 'desc');
        $q = trim((string) $request->query('q', ''));

        if ($q !== '') {
            $query->where(function ($builder) use ($q) {
                $builder->where('title', 'ilike', "%{$q}%")
                    ->orWhere('category', 'ilike', "%{$q}%")
                    ->orWhere('excerpt', 'ilike', "%{$q}%")
                    ->orWhere('content', 'ilike', "%{$q}%");
            });
        }

        $posts = $query->paginate(9)->withQueryString();

        return view('public.blog', compact('posts', 'q'));
    }

    public function show($slug)
    {
        $post = Post::published()->where('slug', $slug)->firstOrFail();

        return view('public.post-detail', compact('post'));
    }
}
