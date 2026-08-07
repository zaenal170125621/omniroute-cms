<?php

namespace App\Http\Controllers;

use App\Models\Page;

class PageController extends Controller
{
    public function show($slug)
    {
        // ModelNotFoundException otomatis jadi 404 oleh exception handler.
        $page = Page::where('slug', $slug)->where('is_active', true)->firstOrFail();

        return view('public.page', compact('page'));
    }
}
