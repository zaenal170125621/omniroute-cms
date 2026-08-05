<?php

namespace App\Http\Controllers;

use App\Models\Portfolio;

class PortfolioController extends Controller
{
    public function index()
    {
        $portfolios = Portfolio::where('is_active', true)->orderBy('sort_order')->get();
        $categories = Portfolio::CATEGORIES;

        return view('public.portfolio', compact('portfolios', 'categories'));
    }

    public function show($slug)
    {
        $portfolio = Portfolio::where('slug', $slug)->where('is_active', true)->firstOrFail();

        return view('public.portfolio-detail', compact('portfolio'));
    }
}
