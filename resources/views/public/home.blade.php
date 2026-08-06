@extends('layouts.public')

@section('title', setting('seo_title', 'OmniRoute Studio'))
@section('meta_description', setting('seo_description', ''))

@php
    $siteSchema = [
        '@context' => 'https://schema.org',
        '@type' => 'WebSite',
        'name' => setting('company_name', 'OmniRoute Studio'),
        'url' => url('/'),
    ];
@endphp
@push('head')
    <script type="application/ld+json">{!! json_encode($siteSchema, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE | JSON_HEX_TAG | JSON_HEX_AMP | JSON_HEX_APOS | JSON_HEX_QUOT) !!}</script>
@endpush

@section('content')

{{-- ============ HERO ============ --}}
<section class="hero">
    <div class="container">
        <span class="hero-badge">{{ setting('hero_badge', 'EST. 2020 — JAKARTA, ID') }}</span>
        <h1>{!! nl2br(e(setting('hero_title', 'Website yang bekerja sekeras tim Anda.'))) !!}</h1>
        <p class="hero-sub">{{ setting('hero_subtitle', '') }}</p>
        <div class="hero-actions">
            <a href="{{ route('order') }}" class="btn btn-light">{{ setting('hero_cta_primary', 'Mulai Proyek') }} →</a>
            <a href="{{ route('portfolio.index') }}" class="btn btn-ghost-light">{{ setting('hero_cta_secondary', 'Lihat Portofolio') }}</a>
        </div>
    </div>
</section>

{{-- Ticker strip --}}
<div class="ticker">
    <div class="ticker-track">
        <span>Company Profile <i>◆</i> E-Commerce <i>◆</i> Landing Page <i>◆</i> Web Application <i>◆</i> UI/UX Design <i>◆</i> SEO &amp; Maintenance <i>◆</i></span>
        <span>Company Profile <i>◆</i> E-Commerce <i>◆</i> Landing Page <i>◆</i> Web Application <i>◆</i> UI/UX Design <i>◆</i> SEO &amp; Maintenance <i>◆</i></span>
    </div>
</div>

{{-- ============ KLIEN ============ --}}
@php
    $clients = array_values(array_filter(array_map('trim', explode(',', (string) setting('clients', 'Nusantara Logistik, Kopi Luhur, Griya Arta, Studio Kayu, Mitra Sejahtera')))));
@endphp
@if ($clients)
<section class="logo-strip">
    <div class="container">
        <div class="logo-strip-inner">
            <span class="logo-strip-label">{{ __('Dipercaya oleh') }}</span>
            <div class="logo-strip-list">
                @foreach ($clients as $client)
                    <span class="logo-strip-item">{{ $client }}</span>
                @endforeach
            </div>
        </div>
    </div>
</section>
@endif

{{-- ============ LAYANAN ============ --}}
<section class="section">
    <div class="container">
        <div class="section-header">
            <div>
                <span class="section-label">{{ __('01 — Layanan') }}</span>
                <h2 class="section-title">{{ __('Apa yang kami kerjakan') }}</h2>
            </div>
            <a href="{{ route('services.index') }}" class="section-link">{{ __('Semua Layanan') }}</a>
        </div>

        <div class="svc-index">
            @foreach ($services as $service)
                <a href="{{ route('services.show', $service->slug) }}" class="svc-row">
                    <span class="svc-row-left">
                        <span class="svc-row-num">{{ str_pad((string) $loop->iteration, 2, '0', STR_PAD_LEFT) }}</span>
                        @if ($icon = service_icon_url($service->icon))
                            <span class="svc-row-icon"><img src="{{ $icon }}" alt="" aria-hidden="true" loading="lazy"></span>
                        @endif
                    </span>
                    <div class="svc-row-body">
                        <h3 class="svc-row-title">{{ $service->title }}</h3>
                        <p class="svc-row-desc">{{ $service->short_description }}</p>
                    </div>
                    <span class="svc-row-price">
                        <span class="svc-price-label">{{ __('Mulai dari') }}</span>
                        {{ $service->starting_price ?: __('Harga fleksibel') }}
                    </span>
                    <span class="svc-row-arrow" aria-hidden="true">→</span>
                </a>
            @endforeach
        </div>
    </div>
</section>

{{-- ============ PORTOFOLIO ============ --}}
<section class="section" style="background:var(--gray-50);">
    <div class="container">
        <div class="section-header">
            <div>
                <span class="section-label">{{ __('02 — Portofolio') }}</span>
                <h2 class="section-title">{{ __('Pekerjaan terpilih') }}</h2>
            </div>
            <a href="{{ route('portfolio.index') }}" class="section-link">{{ __('Semua Karya') }}</a>
        </div>

        <div class="grid-3">
            @foreach ($portfolios as $portfolio)
                <a href="{{ route('portfolio.show', $portfolio->slug) }}" class="card card-link portfolio-card">
                    @if ($portfolio->cover_image)
                        <img src="{{ cover_url($portfolio->cover_image) }}" alt="{{ $portfolio->title }}" loading="lazy" style="aspect-ratio:4/3;object-fit:cover;width:100%;">
                    @else
                        {!! swiss_block($portfolio->cover_color, $portfolio->title, str_pad((string) $loop->iteration, 2, '0', STR_PAD_LEFT)) !!}
                    @endif
                    <div class="card-body">
                        <div class="meta">
                            <span>{{ $portfolio->categoryLabel() }}</span>
                            <span>{{ $portfolio->year }}</span>
                        </div>
                        <h3>{{ $portfolio->title }}</h3>
                    </div>
                </a>
            @endforeach
        </div>
    </div>
</section>

{{-- ============ ANGKA ============ --}}
<section class="section">
    <div class="container">
        <div class="stat-band">
            <div class="stat"><div class="num" data-count="120" data-suffix="+">120<sup>+</sup></div><div class="label">{{ __('Proyek Selesai') }}</div></div>
            <div class="stat"><div class="num" data-count="4.9" data-decimals="1" data-suffix="/5">4,9<sup>/5</sup></div><div class="label">{{ __('Rating Klien') }}</div></div>
            <div class="stat"><div class="num" data-count="98" data-suffix="%">98<sup>%</sup></div><div class="label">{{ __('Klien Merekomendasikan') }}</div></div>
            <div class="stat"><div class="num" data-count="24" data-suffix="h">24<sup>h</sup></div><div class="label">{{ __('Respons Cepat') }}</div></div>
        </div>
    </div>
</section>

{{-- ============ PROSES ============ --}}
<section class="section" style="background:var(--gray-50);">
    <div class="container">
        <div class="section-header">
            <div>
                <span class="section-label">{{ __('Proses') }}</span>
                <h2 class="section-title">{{ __('Cara kami bekerja') }}</h2>
            </div>
        </div>

        <div class="process-grid">
            <div class="process-step">
                <span class="process-num">01</span>
                <h3>{{ __('Brief & Konsultasi') }}</h3>
                <p>{{ __('Diskusi kebutuhan, tujuan, dan lingkup proyek Anda — gratis.') }}</p>
            </div>
            <div class="process-step">
                <span class="process-num">02</span>
                <h3>{{ __('Proposal & Kontrak') }}</h3>
                <p>{{ __('Kami kirim proposal, timeline, dan penawaran yang transparan.') }}</p>
            </div>
            <div class="process-step">
                <span class="process-num">03</span>
                <h3>{{ __('Desain & Pengembangan') }}</h3>
                <p>{{ __('Desain presisi, kode rapi — dengan update progres berkala.') }}</p>
            </div>
            <div class="process-step">
                <span class="process-num">04</span>
                <h3>{{ __('Launch & Dukungan') }}</h3>
                <p>{{ __('Website live, pelatihan konten, dan dukungan purna jual.') }}</p>
            </div>
        </div>
    </div>
</section>

{{-- ============ TESTIMONI ============ --}}
@if ($testimonials->isNotEmpty())
<section class="section">
    <div class="container">
        <div class="section-header">
            <div>
                <span class="section-label">{{ __('03 — Testimoni') }}</span>
                <h2 class="section-title">{{ __('Kata mereka tentang kami') }}</h2>
            </div>
        </div>

        <div class="grid-2">
            @foreach ($testimonials as $testimonial)
                <div class="testimonial">
                    <div class="stars">{{ str_repeat('★', $testimonial->rating) }}</div>
                    <blockquote>“{{ $testimonial->quote }}”</blockquote>
                    <div class="author author-with-photo">
                        @if ($testimonial->photo)
                            <img src="{{ cover_url($testimonial->photo) }}" alt="{{ $testimonial->client_name }}" loading="lazy" class="avatar">
                        @endif
                        <div>
                            <strong>{{ $testimonial->client_name }}</strong>
                            <span>{{ $testimonial->position }}{{ $testimonial->company ? ' — ' . $testimonial->company : '' }}</span>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</section>
@endif

{{-- ============ BLOG ============ --}}
@if ($posts->isNotEmpty())
<section class="section" style="background:var(--gray-50);">
    <div class="container">
        <div class="section-header">
            <div>
                <span class="section-label">{{ __('04 — Insight') }}</span>
                <h2 class="section-title">{{ __('Dari blog kami') }}</h2>
            </div>
            <a href="{{ route('blog.index') }}" class="section-link">{{ __('Semua Artikel') }}</a>
        </div>

        <div class="grid-3">
            @foreach ($posts as $post)
                <a href="{{ route('blog.show', $post->slug) }}" class="card card-link post-card">
                    @if ($post->cover_image)
                        <img src="{{ cover_url($post->cover_image) }}" alt="{{ $post->title }}" loading="lazy" style="aspect-ratio:16/9;object-fit:cover;width:100%;">
                    @else
                        <div class="cover">{{ $post->category ?: __('Artikel') }}</div>
                    @endif
                    <div class="card-body">
                        <h3>{{ $post->title }}</h3>
                        <p>{{ \Illuminate\Support\Str::limit($post->excerpt, 110) }}</p>
                    </div>
                </a>
            @endforeach
        </div>
    </div>
</section>
@endif

{{-- ============ CTA ============ --}}
<section class="cta-band">
    <div class="container">
        <h2>{{ __('Siap membangun website Anda?') }}</h2>
        <p>{{ __('Ceritakan kebutuhan Anda — kami balas dengan proposal dan estimasi dalam 1×24 jam.') }}</p>
        <a href="{{ route('order') }}" class="btn btn-light">{{ __('Mulai Proyek') }} →</a>
    </div>
</section>

@endsection
