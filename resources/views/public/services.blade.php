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

{{-- Proses kerja --}}
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

<section class="cta-band">
    <div class="container">
        <h2>{{ __('Bingung pilih layanan?') }}</h2>
        <p>{{ __('Konsultasi gratis — ceritakan kebutuhan Anda, kami rekomendasikan solusinya.') }}</p>
        <a href="{{ route('order') }}" class="btn btn-light">{{ __('Konsultasi Sekarang') }} →</a>
    </div>
</section>

@endsection
