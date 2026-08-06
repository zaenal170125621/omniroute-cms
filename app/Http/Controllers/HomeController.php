<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Portfolio;
use App\Models\Service;
use App\Models\Testimonial;

class HomeController extends Controller
{
    public function index()
    {
        $services = Service::where('is_active', true)->orderBy('sort_order')->limit(3)->get();
        $portfolios = Portfolio::where('is_active', true)->orderBy('sort_order')->limit(6)->get();
        $testimonials = Testimonial::where('is_active', true)->orderBy('sort_order')->limit(4)->get();
        $posts = Post::published()->orderBy('published_at', 'desc')->limit(3)->get();

        return view('public.home', compact('services', 'portfolios', 'testimonials', 'posts'));
    }
}
