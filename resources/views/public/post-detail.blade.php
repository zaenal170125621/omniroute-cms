@extends('layouts.public')

@section('title', $post->title . ' — Blog ' . setting('company_name', 'OmniRoute Studio'))
@section('meta_description', $post->excerpt)

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

@endsection
