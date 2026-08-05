@extends('layouts.public')

@section('title', __('Blog') . ' — ' . setting('company_name', 'OmniRoute Studio'))

@section('content')

<section class="page-hero">
    <div class="container">
        <span class="section-label">{{ __('04 — Insight') }}</span>
        <h1>{{ __('Blog') }}</h1>
        <p class="lead">{{ __('Panduan, tren, dan pemikiran seputar website, desain, dan bisnis digital.') }}</p>
    </div>
</section>

<section class="section">
    <div class="container">
        <form method="GET" action="{{ route('blog.index') }}" class="blog-search">
            <input type="search" name="q" value="{{ $q }}" placeholder="{{ __('Cari artikel...') }}" aria-label="{{ __('Cari artikel...') }}">
            <button type="submit" class="btn btn-sm">{{ __('Cari') }}</button>
            @if ($q)
                <a href="{{ route('blog.index') }}" class="pill">{{ __('✕ Hapus pencarian') }}</a>
            @endif
        </form>

        @if ($q && !$posts->isEmpty())
            <p style="font-size:12px;font-weight:700;letter-spacing:0.1em;text-transform:uppercase;color:var(--gray-400);margin-bottom:24px;">
                {{ $posts->total() }} {{ __('artikel untuk') }} "{{ $q }}"
            </p>
        @endif

        @if ($posts->isEmpty())
            <p style="text-align:center;color:var(--gray-400);padding:64px 0;">
                @if ($q)
                    {{ __('Tidak ada artikel untuk') }} "{{ $q }}". {{ __('Coba kata kunci lain.') }}
                @else
                    {{ __('Belum ada artikel. Kembali lagi nanti.') }}
                @endif
            </p>
        @else
            <div class="grid-3">
                @foreach ($posts as $post)
                    <a href="{{ route('blog.show', $post->slug) }}" class="card card-link post-card">
                        @if ($post->cover_image)
                            <img src="{{ cover_url($post->cover_image) }}" alt="{{ $post->title }}" loading="lazy" style="aspect-ratio:16/9;object-fit:cover;width:100%;">
                        @else
                            <div class="cover">{{ $post->category ?: __('Artikel') }}</div>
                        @endif
                        <div class="card-body">
                            <div class="meta" style="display:flex;justify-content:space-between;font-size:11px;font-weight:700;letter-spacing:0.1em;text-transform:uppercase;color:var(--gray-400);margin-bottom:10px;">
                                <span>{{ $post->category ?: 'Artikel' }}</span>
                                <span>{{ $post->publishedDate() }}</span>
                            </div>
                            <h3>{{ $post->title }}</h3>
                            <p>{{ \Illuminate\Support\Str::limit($post->excerpt, 110) }}</p>
                        </div>
                    </a>
                @endforeach
            </div>

            @if ($posts->hasPages())
                <div class="pagination">
                    {{ $posts->links() }}
                </div>
            @endif
        @endif
    </div>
</section>

@endsection
