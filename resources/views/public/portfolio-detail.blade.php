@extends('layouts.public')

@section('title', $portfolio->title . ' — Portofolio ' . setting('company_name', 'OmniRoute Studio'))
@section('meta_description', \Illuminate\Support\Str::limit($portfolio->description, 160))
@section('og_image', $portfolio->cover_image ? cover_url($portfolio->cover_image) : asset('images/hero.jpg'))
@section('wa_message', 'Halo, saya melihat portofolio "' . $portfolio->title . '" dan ingin membuat proyek serupa. Bisa dibantu?')

@php
    $crumbSchema = [
        '@context' => 'https://schema.org',
        '@type' => 'BreadcrumbList',
        'itemListElement' => [
            ['@type' => 'ListItem', 'position' => 1, 'name' => __('Beranda'), 'item' => route('home')],
            ['@type' => 'ListItem', 'position' => 2, 'name' => __('Portofolio'), 'item' => route('portfolio.index')],
            ['@type' => 'ListItem', 'position' => 3, 'name' => $portfolio->title, 'item' => url()->current()],
        ],
    ];
@endphp
@push('head')
    <script type="application/ld+json">{!! json_encode($crumbSchema, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE | JSON_HEX_TAG | JSON_HEX_AMP | JSON_HEX_APOS | JSON_HEX_QUOT) !!}</script>
@endpush

@section('content')

<section class="detail-hero">
    <div class="container">
        <nav class="breadcrumb" aria-label="Breadcrumb">
            <a href="{{ route('home') }}">{{ __('Beranda') }}</a>
            <span class="sep" aria-hidden="true">/</span>
            <a href="{{ route('portfolio.index') }}">{{ __('Portofolio') }}</a>
            <span class="sep" aria-hidden="true">/</span>
            <span aria-current="page">{{ $portfolio->title }}</span>
        </nav>
        <span class="section-label">Portofolio — {{ $portfolio->categoryLabel() }}</span>
        <h1>{{ $portfolio->title }}</h1>
        <div class="detail-meta">
            @if ($portfolio->client_name)
                <span>{{ __('Klien') }} <b>{{ $portfolio->client_name }}</b></span>
            @endif
            @if ($portfolio->year)
                <span>{{ __('Tahun') }} <b>{{ $portfolio->year }}</b></span>
            @endif
            <span>{{ __('Kategori') }} <b>{{ $portfolio->categoryLabel() }}</b></span>
            @if ($portfolio->duration)
                <span>{{ __('Durasi') }} <b>{{ $portfolio->duration }}</b></span>
            @endif
        </div>
    </div>
</section>

<section class="section">
    <div class="container">
        @if ($portfolio->cover_image)
            <img src="{{ cover_url($portfolio->cover_image) }}" alt="{{ $portfolio->title }}" class="case-cover">
        @else
            {!! swiss_block($portfolio->cover_color, $portfolio->title, '00') !!}
        @endif

        @if (!empty($portfolio->metrics))
            <div class="cs-metrics">
                @foreach ($portfolio->metrics as $metric)
                    <div class="cs-metric">
                        <div class="cs-metric-num">{{ $metric['value'] ?? '' }}</div>
                        <div class="cs-metric-label">{{ $metric['label'] ?? '' }}</div>
                    </div>
                @endforeach
            </div>
        @endif

        <div class="case-grid">
            <div class="case-main">
                <div class="prose">{!! markdown($portfolio->description) !!}</div>

                @if ($portfolio->challenge)
                    <div class="cs-block">
                        <span class="cs-block-label">{{ __('Tantangan') }}</span>
                        <p>{{ $portfolio->challenge }}</p>
                    </div>
                @endif
                @if ($portfolio->solution)
                    <div class="cs-block">
                        <span class="cs-block-label">{{ __('Solusi') }}</span>
                        <p>{{ $portfolio->solution }}</p>
                    </div>
                @endif
                @if ($portfolio->result)
                    <div class="cs-block">
                        <span class="cs-block-label">{{ __('Hasil') }}</span>
                        <p>{{ $portfolio->result }}</p>
                    </div>
                @endif
            </div>

            <aside class="case-aside">
                <div class="card" style="padding:28px;">
                    <dl class="case-meta-list">
                        @if ($portfolio->client_name)
                            <div class="case-meta"><dt>{{ __('Klien') }}</dt><dd>{{ $portfolio->client_name }}</dd></div>
                        @endif
                        @if ($portfolio->year)
                            <div class="case-meta"><dt>{{ __('Tahun') }}</dt><dd>{{ $portfolio->year }}</dd></div>
                        @endif
                        <div class="case-meta"><dt>{{ __('Kategori') }}</dt><dd>{{ $portfolio->categoryLabel() }}</dd></div>
                        @if ($portfolio->duration)
                            <div class="case-meta"><dt>{{ __('Durasi') }}</dt><dd>{{ $portfolio->duration }}</dd></div>
                        @endif
                    </dl>
                    @if ($portfolio->tech_stack)
                        <h4 style="font-size:12px;font-weight:700;letter-spacing:0.1em;text-transform:uppercase;color:var(--gray-600);margin-bottom:12px;">{{ __('Teknologi') }}</h4>
                        <div class="tech-tags" style="margin:0 0 24px;">
                            @foreach ($portfolio->tech_stack as $tech)
                                <span class="tech-tag">{{ $tech }}</span>
                            @endforeach
                        </div>
                    @endif
                    @if ($portfolio->link)
                        <a href="{{ $portfolio->link }}" target="_blank" rel="noopener" class="btn btn-block" style="margin-bottom:12px;">{{ __('Kunjungi Live') }} ↗</a>
                    @endif
                    <a href="{{ route('order') }}" class="btn btn-outline btn-block">{{ __('Ingin Serupa?') }} →</a>
                </div>
            </aside>
        </div>
    </div>
</section>

@endsection
