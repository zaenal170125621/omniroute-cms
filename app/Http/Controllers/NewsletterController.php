<?php

namespace App\Http\Controllers;

use App\Models\NewsletterSubscriber;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class NewsletterController extends Controller
{
    public function subscribe(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'email' => ['required', 'email', 'max:255'],
        ]);

        $locale = $request->hasHeader('Accept-Language') 
            ? substr($request->header('Accept-Language'), 0, 2)
            : app()->getLocale();
        
        $locale = in_array($locale, ['id', 'en']) ? $locale : 'id';

        $subscriber = NewsletterSubscriber::subscribe($validated['email'], $locale);

        // TODO: Send confirmation email (when SMTP configured)
        // For now, auto-confirm for demo
        if (!$subscriber->confirmed) {
            $subscriber->confirm();
        }

        return response()->json([
            'success' => true,
            'message' => __('Terima kasih! Cek email untuk konfirmasi.'),
        ]);
    }

    public function confirm(string $token): \Illuminate\Http\RedirectResponse
    {
        $subscriber = NewsletterSubscriber::where('confirmation_token', $token)->firstOrFail();
        $subscriber->confirm();

        return redirect()->route('home')->with('success', 'Langganan newsletter dikonfirmasi. Terima kasih!');
    }
}