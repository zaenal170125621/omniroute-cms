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

        $related = Post::published()
            ->where('id', '!=', $post->id)
            ->when($post->category, fn ($query) => $query->where('category', $post->category))
            ->orderBy('published_at', 'desc')
            ->limit(3)
            ->get();

        if ($related->count() < 3) {
            $fill = Post::published()
                ->where('id', '!=', $post->id)
                ->whereNotIn('id', $related->pluck('id'))
                ->orderBy('published_at', 'desc')
                ->limit(3 - $related->count())
                ->get();

            $related = $related->merge($fill);
        }

        return view('public.post-detail', compact('post', 'related'));
    }
}
