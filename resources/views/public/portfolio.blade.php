@extends('layouts.public')

@section('title', __('Portofolio') . ' — ' . setting('company_name', 'OmniRoute Studio'))

@section('content')

<section class="page-hero">
    <div class="container">
        <span class="section-label">{{ __('02 — Portofolio') }}</span>
        <h1>{{ __('Karya terpilih') }}</h1>
        <p class="lead">{{ __('Setiap proyek adalah bukti: desain presisi yang menghasilkan.') }}</p>
    </div>
</section>

<section class="section">
    <div class="container">
        <div class="filter-bar">
            <button class="pill active" data-filter="all">{{ __('Semua') }}</button>
            @foreach ($categories as $key => $label)
                <button class="pill" data-filter="{{ $key }}">{{ $label }}</button>
            @endforeach
        </div>

        <div class="grid-3">
            @foreach ($portfolios as $portfolio)
                <a href="{{ route('portfolio.show', $portfolio->slug) }}" class="card card-link portfolio-card" data-category="{{ $portfolio->category }}" data-description="{{ $portfolio->description }}" data-tech="{{ implode(', ', $portfolio->tech_stack) }}">
                    @if ($portfolio->cover_image)
                        <img src="{{ cover_url($portfolio->cover_image) }}" alt="{{ $portfolio->title }}" loading="lazy" style="aspect-ratio:4/3;object-fit:cover;width:100%">
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

<section class="cta-band">
    <div class="container">
        <h2>{{ __('Karya berikutnya bisa milik Anda') }}</h2>
        <p>{{ __('Ceritakan visi Anda — kami wujudkan dalam bentuk website.') }}</p>
        <a href="{{ route('order') }}" class="btn btn-light">{{ __('Mulai Proyek') }} →</a>
    </div>
</section>

@endsection
