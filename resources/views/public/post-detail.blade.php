@extends('layouts.public')

@section('title', $post->title . ' — Blog ' . setting('company_name', 'OmniRoute Studio'))
@section('meta_description', $post->excerpt)
@section('og_image', $post->cover_image ? cover_url($post->cover_image) : asset('images/hero.jpg'))

@php
    $orgSchema = [
        '@type' => 'Organization',
        'name' => setting('company_name', 'OmniRoute Studio'),
        'url' => url('/'),
        'logo' => [
            '@type' => 'ImageObject',
            'url' => asset('images/hero.jpg'),
        ],
    ];
    $articleSchema = [
        '@context' => 'https://schema.org',
        '@type' => 'Article',
        'headline' => $post->title,
        'description' => $post->excerpt,
        'datePublished' => $post->published_at?->toIso8601String(),
        'author' => $orgSchema,
        'publisher' => $orgSchema,
        'mainEntityOfPage' => url()->current(),
    ];
    $crumbSchema = [
        '@context' => 'https://schema.org',
        '@type' => 'BreadcrumbList',
        'itemListElement' => [
            ['@type' => 'ListItem', 'position' => 1, 'name' => __('Beranda'), 'item' => route('home')],
            ['@type' => 'ListItem', 'position' => 2, 'name' => __('Blog'), 'item' => route('blog.index')],
            ['@type' => 'ListItem', 'position' => 3, 'name' => $post->title, 'item' => url()->current()],
        ],
    ];
@endphp
@push('head')
    <script type="application/ld+json">{!! json_encode($articleSchema, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE | JSON_HEX_TAG | JSON_HEX_AMP | JSON_HEX_APOS | JSON_HEX_QUOT) !!}</script>
    <script type="application/ld+json">{!! json_encode($crumbSchema, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE | JSON_HEX_TAG | JSON_HEX_AMP | JSON_HEX_APOS | JSON_HEX_QUOT) !!}</script>
@endpush

@section('content')

<section class="detail-hero">
    <div class="container" style="max-width:820px;">
        <nav class="breadcrumb" aria-label="Breadcrumb">
            <a href="{{ route('home') }}">{{ __('Beranda') }}</a>
            <span class="sep" aria-hidden="true">/</span>
            <a href="{{ route('blog.index') }}">{{ __('Blog') }}</a>
            <span class="sep" aria-hidden="true">/</span>
            <span aria-current="page">{{ $post->title }}</span>
        </nav>
        <span class="section-label">{{ $post->category ?: 'Artikel' }}</span>
        <h1>{{ $post->title }}</h1>
        <div class="detail-meta">
            <span>Ditulis <b>{{ $post->publishedDate() }}</b></span>
        </div>
    </div>
</section>

<section class="section">
    <div class="container" style="max-width:820px;">
        @if ($post->cover_image)
            <img src="{{ cover_url($post->cover_image) }}" alt="{{ $post->title }}" loading="lazy" style="width:100%;aspect-ratio:16/9;object-fit:cover;margin-bottom:48px;border:1px solid var(--gray-200);">
        @endif
        <article class="prose">{!! markdown($post->content) !!}</article>

        <div style="margin-top:64px;padding-top:32px;border-top:1px solid var(--gray-200);display:flex;justify-content:space-between;align-items:center;flex-wrap:wrap;gap:16px;">
            <a href="{{ route('blog.index') }}" class="section-link">← Semua Artikel</a>
            <a href="{{ route('order') }}" class="btn btn-sm">Mulai Proyek →</a>
        </div>
    </div>
</section>

@if ($related->isNotEmpty())
<section class="section" style="background:var(--gray-50);">
    <div class="container">
        <div class="section-header">
            <div>
                <span class="section-label">{{ __('Baca juga') }}</span>
                <h2 class="section-title">{{ __('Artikel terkait') }}</h2>
            </div>
            <a href="{{ route('blog.index') }}" class="section-link">{{ __('Semua Artikel') }}</a>
        </div>

        <div class="grid-3">
            @foreach ($related as $relatedPost)
                <a href="{{ route('blog.show', $relatedPost->slug) }}" class="card card-link post-card">
                    @if ($relatedPost->cover_image)
                        <img src="{{ cover_url($relatedPost->cover_image) }}" alt="{{ $relatedPost->title }}" loading="lazy" style="aspect-ratio:16/9;object-fit:cover;width:100%;">
                    @else
                        <div class="cover">{{ $relatedPost->category ?: __('Artikel') }}</div>
                    @endif
                    <div class="card-body">
                        <div class="meta" style="display:flex;justify-content:space-between;font-size:11px;font-weight:700;letter-spacing:0.1em;text-transform:uppercase;color:var(--gray-500);margin-bottom:10px;">
                            <span>{{ $relatedPost->category ?: 'Artikel' }}</span>
                            <span>{{ $relatedPost->publishedDate() }}</span>
                        </div>
                        <h3>{{ $relatedPost->title }}</h3>
                    </div>
                </a>
            @endforeach
        </div>
    </div>
</section>
@endif

@endsection
