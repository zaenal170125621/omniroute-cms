<?php

namespace App\Http\Controllers;

use App\Models\Lead;
use Illuminate\Http\Request;

class ContactController extends Controller
{
    public function show()
    {
        return view('public.contact');
    }

    public function store(Request $request)
    {
        // Honeypot anti-spam: bot cenderung mengisi field tersembunyi,
        // manusia membiarkannya kosong. Jika terisi, diam-diam anggap sukses.
        if ($request->filled('company_site')) {
            return redirect()->route('contact')->with('success', 'Pesan terkirim! Tim kami akan menghubungi Anda dalam 1×24 jam.');
        }

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255'],
            'phone' => ['nullable', 'string', 'max:50'],
            'company' => ['nullable', 'string', 'max:255'],
            'message' => ['required', 'string', 'max:5000'],
        ]);

        $lead = Lead::create(array_merge($validated, [
            'source' => 'contact',
            'status' => 'baru',
        ]));

        notify_lead_sales($lead);

        return redirect()->route('contact')->with('success', 'Pesan terkirim! Tim kami akan menghubungi Anda dalam 1×24 jam.');
    }
}
