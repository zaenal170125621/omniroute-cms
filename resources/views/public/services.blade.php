@extends('layouts.public')

@section('title', __('Layanan') . ' — ' . setting('company_name', 'OmniRoute Studio'))

@section('content')

<section class="page-hero">
    <div class="container">
        <span class="section-label">{{ __('01 — Layanan') }}</span>
        <h1>{{ __('Layanan kami') }}</h1>
        <p class="lead">{{ __('Dari landing page hingga web application — semua dikerjakan dengan desain presisi dan kode yang rapi.') }}</p>
    </div>
</section>

<section class="section">
    <div class="container">
        <div class="grid-2">
            @foreach ($services as $service)
                <a href="{{ route('services.show', $service->slug) }}" class="card card-link service-card">
                    <div class="card-body">
                        <div class="icon icon-img">
                            @if ($icon = service_icon_url($service->icon))
                                <img src="{{ $icon }}" alt="{{ $service->title }}" loading="lazy">
                            @else
                                {{ strtoupper(substr($service->icon, 0, 2)) }}
                            @endif
                        </div>
                        <h3>{{ $service->title }}</h3>
                        <p>{{ $service->short_description }}</p>
                        <span class="price">{{ $service->starting_price ? __('Mulai') . ' ' . $service->starting_price : __('Harga fleksibel') }}</span>
                        <span class="arrow" style="float:right;">→</span>
                    </div>
                </a>
            @endforeach
        </div>
    </div>
</section>

<section class="cta-band">
    <div class="container">
        <h2>{{ __('Bingung pilih layanan?') }}</h2>
        <p>{{ __('Konsultasi gratis — ceritakan kebutuhan Anda, kami rekomendasikan solusinya.') }}</p>
        <a href="{{ route('order') }}" class="btn btn-light">{{ __('Konsultasi Sekarang') }} →</a>
    </div>
</section>

@endsection
