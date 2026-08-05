<?php

namespace App\Http\Controllers;

use App\Models\Page;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class PageController extends Controller
{
    public function show($slug)
    {
        try {
            $page = Page::where('slug', $slug)->where('is_active', true)->firstOrFail();
        } catch (ModelNotFoundException $e) {
            abort(404);
        }

        return view('public.page', compact('page'));
    }
}
