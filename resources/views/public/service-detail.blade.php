@extends('layouts.public')

@section('title', $service->title . ' — ' . setting('company_name', 'OmniRoute Studio'))
@section('meta_description', $service->short_description)
@section('wa_message', 'Halo, saya tertarik dengan layanan "' . $service->title . '". Bisakah info lebih lanjut?')

@php
    $svcPrice = (int) preg_replace('/[^0-9]/', '', (string) $service->starting_price);
    $svcSchema = [
        '@context' => 'https://schema.org',
        '@type' => 'Service',
        'name' => $service->title,
        'description' => $service->short_description,
        'url' => url()->current(),
        'provider' => [
            '@type' => 'Organization',
            'name' => setting('company_name', 'OmniRoute Studio'),
            'url' => url('/'),
        ],
    ];
    if ($svcPrice > 0) {
        $svcSchema['offers'] = [
            '@type' => 'Offer',
            'priceCurrency' => 'IDR',
            'price' => (string) $svcPrice,
        ];
    }
@endphp
@push('head')
    <script type="application/ld+json">{!! json_encode($svcSchema, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE | JSON_HEX_TAG | JSON_HEX_AMP | JSON_HEX_APOS | JSON_HEX_QUOT) !!}</script>
@endpush

@section('content')

<section class="detail-hero">
    <div class="container">
        <nav class="breadcrumb" aria-label="Breadcrumb">
            <a href="{{ route('home') }}">{{ __('Beranda') }}</a>
            <span class="sep" aria-hidden="true">/</span>
            <a href="{{ route('services.index') }}">{{ __('Layanan') }}</a>
            <span class="sep" aria-hidden="true">/</span>
            <span aria-current="page">{{ $service->title }}</span>
        </nav>
        <span class="section-label">Layanan — {{ $service->title }}</span>
        <h1>{{ $service->title }}</h1>
        <div class="detail-meta">
            @if ($service->starting_price)
                <span>Mulai dari <b>{{ $service->starting_price }}</b></span>
            @endif
        </div>
    </div>
</section>

<section class="section">
    <div class="container">
        <div style="display:grid;grid-template-columns:1.6fr 1fr;gap:56px;align-items:start;">
            <div>
                <div class="prose">{!! markdown($service->description) !!}</div>

                @if ($service->features)
                    <h3 style="margin-top:48px;font-size:20px;">Termasuk di dalamnya</h3>
                    <ul class="feature-list">
                        @foreach ($service->features as $feature)
                            <li>{{ $feature }}</li>
                        @endforeach
                    </ul>
                @endif
            </div>

            <div style="position:sticky;top:88px;">
                <div class="card" style="padding:32px;">
                    <span class="section-label">Estimasi</span>
                    <div style="font-size:40px;font-weight:800;letter-spacing:-0.02em;margin:12px 0 4px;">
                        {{ $service->starting_price ?: 'Fleksibel' }}
                    </div>
                    <p style="font-size:13px;color:var(--gray-600);margin-bottom:24px;">
                        Harga final ditentukan setelah diskusi kebutuhan Anda.
                    </p>
                    <a href="{{ route('order') }}" class="btn btn-block" style="margin-bottom:12px;">Mulai Proyek →</a>
                    <a href="{{ route('contact') }}" class="btn btn-outline btn-block">Tanya Dulu</a>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="cta-band">
    <div class="container">
        <h2>Butuh {{ strtolower($service->title) }}?</h2>
        <p>Mulai proyek Anda hari ini — respons maksimal 1×24 jam.</p>
        <a href="{{ route('order') }}" class="btn btn-light">Mulai Proyek →</a>
    </div>
</section>

@endsection
