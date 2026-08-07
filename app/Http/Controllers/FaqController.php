<?php

namespace App\Http\Controllers;

use App\Models\Faq;

class FaqController extends Controller
{
    public function index()
    {
        $faqs = Faq::orderBy('sort_order')->get(['question', 'answer']);

        if ($faqs->isEmpty()) {
            $faqs = collect(Faq::DEFAULTS);
        }

        return view('public.faq', compact('faqs'));
    }
}
