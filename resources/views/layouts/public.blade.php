<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script>
        (function () {
            try {
                var saved = localStorage.getItem('theme');
                var theme = saved || (window.matchMedia('(prefers-color-scheme: dark)').matches ? 'dark' : 'light');
                document.documentElement.setAttribute('data-theme', theme);
            } catch (e) {}
        })();
    </script>
    <title>@yield('title', setting('seo_title', 'OmniRoute Studio'))</title>
    <meta name="description" content="@yield('meta_description', setting('seo_description', ''))">
    <meta property="og:type" content="website">
    <meta property="og:site_name" content="{{ setting('company_name', 'OmniRoute Studio') }}">
    <meta property="og:title" content="@yield('title', setting('seo_title', 'OmniRoute Studio'))">
    <meta property="og:description" content="@yield('meta_description', setting('seo_description', ''))">
    <meta property="og:url" content="{{ url()->current() }}">
    <meta property="og:image" content="@yield('og_image', asset('images/hero.jpg'))">
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="@yield('title', setting('seo_title', 'OmniRoute Studio'))">
    <meta name="twitter:description" content="@yield('meta_description', setting('seo_description', ''))">
    <meta name="twitter:image" content="@yield('og_image', asset('images/hero.jpg'))">
    <link rel="canonical" href="{{ url()->current() }}">
    <link rel="icon" type="image/svg+xml" href="{{ asset('favicon.svg') }}">
    
    {{-- Performance: preconnect fonts & preload hero --}}
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link rel="preload" as="image" href="{{ asset('images/hero.jpg') }}">
    
    {{-- hreflang untuk multi-bahasa --}}
    <link rel="alternate" hreflang="id" href="{{ route('home') }}">
    <link rel="alternate" hreflang="en" href="{{ route('home') }}?lang=en">
    <link rel="alternate" hreflang="x-default" href="{{ route('home') }}">
    
    <link rel="stylesheet" href="{{ asset('vendor/bootstrap/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/public.css') }}">
    @stack('head')
    @if (setting('analytics_head'))
        {!! setting('analytics_head') !!}
    @endif

    {{-- Structured data: Organization (seluruh situs) --}}
    @php
        $whatsappClean = preg_replace('/[^0-9]/', '', (string) setting('whatsapp', ''));
        $orgSchema = [
            '@context' => 'https://schema.org',
            '@type' => 'Organization',
            'name' => setting('company_name', 'OmniRoute Studio'),
            'url' => url('/'),
            'logo' => asset('images/hero.jpg'),
            'description' => setting('seo_description', ''),
            'contactPoint' => [
                '@type' => 'ContactPoint',
                'telephone' => $whatsappClean ? '+' . $whatsappClean : null,
                'contactType' => 'sales',
            ],
            'aggregateRating' => [
                '@type' => 'AggregateRating',
                'ratingValue' => '4.9',
                'reviewCount' => '120',
            ],
            'sameAs' => array_values(array_filter([
                setting('instagram'),
                setting('linkedin'),
                $whatsappClean ? 'https://wa.me/' . $whatsappClean : null,
            ])),
        ];
    @endphp
    <script type="application/ld+json">{!! json_encode($orgSchema, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE | JSON_HEX_TAG | JSON_HEX_AMP | JSON_HEX_APOS | JSON_HEX_QUOT) !!}</script>
</head>
<body>

<header class="site-header">
    <div class="container header-inner">
        <a href="{{ route('home') }}" class="logo">{{ setting('logo_text', 'OmniRoute') }}<sup>®</sup></a>

        <nav class="nav" id="main-nav">
            <a href="{{ route('services.index') }}" class="{{ request()->routeIs('services.*') ? 'active' : '' }}">{{ __('Layanan') }}</a>
            <a href="{{ route('portfolio.index') }}" class="{{ request()->routeIs('portfolio.*') ? 'active' : '' }}">{{ __('Portofolio') }}</a>
            <a href="{{ route('pages.show', 'pricing') }}" class="{{ request()->is('pricing') ? 'active' : '' }}">{{ __('Harga') }}</a>
            <a href="{{ route('blog.index') }}" class="{{ request()->routeIs('blog.*') ? 'active' : '' }}">{{ __('Blog') }}</a>
            <a href="{{ route('faq') }}" class="{{ request()->routeIs('faq') ? 'active' : '' }}">{{ __('FAQ') }}</a>
            <a href="{{ route('pages.show', 'about') }}" class="{{ request()->is('about') ? 'active' : '' }}">{{ __('Tentang') }}</a>
            <a href="{{ route('contact') }}" class="{{ request()->routeIs('contact') ? 'active' : '' }}">{{ __('Kontak') }}</a>
        </nav>

        <div class="header-actions">
            <div class="lang-switch" role="group" aria-label="Language / Bahasa">
                @if (app()->getLocale() === 'id')
                    <a href="{{ route('lang.switch', 'en') }}" aria-label="Switch to English">EN</a>
                @else
                    <a href="{{ route('lang.switch', 'id') }}" aria-label="Ganti ke Bahasa Indonesia">ID</a>
                @endif
            </div>
            <button class="theme-toggle" id="theme-toggle" type="button" aria-label="{{ __('Ganti mode gelap/terang') }}">
                <span class="theme-icon" aria-hidden="true"></span>
            </button>
            <a href="{{ route('order') }}" class="btn btn-sm header-cta">{{ __('Mulai Proyek') }}</a>
            <button class="menu-toggle" aria-label="Menu">☰</button>
        </div>
    </div>
</header>

<main>
    @if (session('success'))
        <div class="container" style="padding-top:24px;">
            <div class="alert alert-success">{{ session('success') }}</div>
        </div>
    @endif

    @if ($errors->any())
        <div class="container" style="padding-top:24px;">
            <div class="alert alert-error">
                @foreach ($errors->all() as $error)
                    <div>{{ $error }}</div>
                @endforeach
            </div>
        </div>
    @endif

    @yield('content')
</main>

<footer class="site-footer">
    <div class="container">
        <div class="footer-grid">
            <div class="footer-brand">
                <a href="{{ route('home') }}" class="logo">{{ setting('logo_text', 'OmniRoute') }}<sup>®</sup></a>
                <p>{{ __(setting('footer_text', 'Desain presisi. Kode rapi. Hasil yang dapat diukur.')) }}</p>
            </div>
            <div class="footer-col">
                <h4>{{ __('Navigasi') }}</h4>
                <a href="{{ route('services.index') }}">{{ __('Layanan') }}</a>
                <a href="{{ route('portfolio.index') }}">{{ __('Portofolio') }}</a>
                <a href="{{ route('pages.show', 'pricing') }}">{{ __('Harga') }}</a>
                <a href="{{ route('blog.index') }}">{{ __('Blog') }}</a>
            </div>
            <div class="footer-col">
                <h4>{{ __('Perusahaan') }}</h4>
                <a href="{{ route('pages.show', 'about') }}">{{ __('Tentang Kami') }}</a>
                <a href="{{ route('faq') }}">{{ __('FAQ') }}</a>
                <a href="{{ route('contact') }}">{{ __('Kontak') }}</a>
                <a href="{{ route('pages.show', 'terms') }}">{{ __('Syarat & Ketentuan') }}</a>
                <a href="{{ route('pages.show', 'privacy') }}">{{ __('Kebijakan Privasi') }}</a>
            </div>
            <div class="footer-col">
                <h4>{{ __('Kontak') }}</h4>
                <ul>
                    <li>{{ setting('email', '') }}</li>
                    <li>{{ setting('phone', '') }}</li>
                    <li>{{ setting('address', '') }}</li>
                </ul>
                @if (setting('instagram'))
                    <a href="{{ setting('instagram') }}" target="_blank" rel="noopener">Instagram</a>
                @endif
                @if (setting('linkedin'))
                    <a href="{{ setting('linkedin') }}" target="_blank" rel="noopener">LinkedIn</a>
                @endif
            </div>
        </div>
        
        {{-- Newsletter signup --}}
        <div class="footer-newsletter" style="margin-top:32px;padding-top:32px;border-top:1px solid var(--gray-200);">
            <h4 style="margin-bottom:12px;">{{ __('Berlangganan Update') }}</h4>
            <p style="font-size:13px;color:var(--gray-600);margin-bottom:16px;">{{ __('Tips desain, tren web, dan kasus kami — max 1 email/bulan.') }}</p>
            <form class="newsletter-form" action="{{ route('newsletter.subscribe') }}" method="POST" data-toast="{{ __('Terima kasih! Cek email untuk konfirmasi.') }}">
                @csrf
                <input type="email" name="email" placeholder="{{ __('email@anda.com') }}" required aria-label="{{ __('Alamat email') }}">
                <button type="submit" class="btn btn-sm">{{ __('Langganan') }}</button>
            </form>
        </div>
        
        <div class="footer-bottom">
            <span>© {{ date('Y') }} {{ setting('company_name', 'OmniRoute Studio') }}. {{ __('All rights reserved.') }}</span>
            <span><a href="{{ route('order') }}">{{ __('Mulai Proyek') }} →</a></span>
        </div>
    </div>
</footer>

{{-- CTA mobile mengambang --}}
<a class="mobile-cta" id="mobile-cta" href="{{ route('order') }}">{{ __('Mulai Proyek') }} →</a>

{{-- Tombol WhatsApp mengambang (pesan otomatis per halaman) --}}
@php
    $waNumber = preg_replace('/[^0-9]/', '', (string) setting('whatsapp', ''));
    $waMessage = trim((string) $__env->yieldContent('wa_message', __('Halo, saya ingin bertanya tentang layanan Anda.')));
    $waHref = 'https://wa.me/' . $waNumber . '?text=' . rawurlencode($waMessage);
@endphp
@if ($waNumber)
    <a class="wa-float" href="{{ $waHref }}" target="_blank" rel="noopener" aria-label="{{ __('Chat WhatsApp') }}">
        <svg viewBox="0 0 24 24" width="28" height="28" fill="currentColor" aria-hidden="true"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/></svg>
    </a>
@endif

{{-- Tombol kembali ke atas --}}
<button class="to-top" id="to-top" type="button" aria-label="{{ __('Kembali ke atas') }}" hidden>↑</button>

{{-- JavaScript Translations --}}
<script>
    window.translations = @json(__('*'));
    window.t = function(key) {
        return (window.translations && window.translations[key]) ? window.translations[key] : key;
    };
</script>

<script src="{{ asset('vendor/bootstrap/bootstrap.bundle.min.js') }}"></script>
<script src="{{ asset('js/app.js') }}"></script>
</body>
</html>
