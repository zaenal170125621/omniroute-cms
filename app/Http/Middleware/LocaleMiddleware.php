<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class LocaleMiddleware
{
    /**
     * Menentukan bahasa aktif dari session (diatur lewat /lang/{locale}).
     * Fallback: locale bawaan aplikasi ('id').
     */
    public function handle(Request $request, Closure $next)
    {
        $locale = Session::get('locale', config('app.locale'));
        $locale = in_array($locale, ['id', 'en'], true) ? $locale : 'id';

        app()->setLocale($locale);

        return $next($request);
    }
}
