<?php

namespace App\Http\Controllers;

use App\Mail\NewsletterConfirmation;
use App\Models\NewsletterSubscriber;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class NewsletterController extends Controller
{
    public function subscribe(Request $request): JsonResponse
    {
        // Honeypot anti-spam (lihat ContactController::store) — diam-diam anggap sukses.
        if ($request->filled('company_site')) {
            return response()->json(['success' => true, 'message' => '']);
        }

        $validated = $request->validate([
            'email' => ['required', 'email', 'max:255'],
        ]);

        $locale = $request->hasHeader('Accept-Language')
            ? substr($request->header('Accept-Language'), 0, 2)
            : app()->getLocale();

        $locale = in_array($locale, ['id', 'en']) ? $locale : 'id';

        $subscriber = NewsletterSubscriber::subscribe($validated['email'], $locale);

        if ($subscriber->confirmed) {
            return response()->json([
                'success' => true,
                'message' => __('Email Anda sudah terdaftar dan aktif.'),
            ]);
        }

        // ponytail: double opt-in via email — subscriber belum aktif sampai klik
        // link konfirmasi. Kegagalan SMTP tidak menghentikan alur; subscriber bisa
        // submit ulang untuk kirim ulang (token digenerate ulang oleh model).
        try {
            Mail::to($subscriber->email)->send(new NewsletterConfirmation($subscriber));
        } catch (\Throwable $e) {
            Log::warning('Email konfirmasi newsletter gagal terkirim ke ' . $subscriber->email . ': ' . $e->getMessage());
        }

        return response()->json([
            'success' => true,
            'message' => __('Cek email Anda untuk konfirmasi langganan.'),
        ]);
    }

    public function confirm(string $token): \Illuminate\Http\RedirectResponse
    {
        $subscriber = NewsletterSubscriber::where('confirmation_token', $token)->firstOrFail();
        $subscriber->confirm();

        return redirect()->route('home')->with('success', 'Langganan newsletter dikonfirmasi. Terima kasih!');
    }
}
