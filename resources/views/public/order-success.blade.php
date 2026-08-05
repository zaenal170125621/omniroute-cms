@extends('layouts.public')

@section('title', __('Permintaan Terkirim') . ' — ' . setting('company_name', 'OmniRoute Studio'))

@section('content')

<section class="section" style="padding-top:120px;">
    <div class="container" style="max-width:640px;text-align:center;">
        <span class="hero-badge" style="border-color:var(--black);">{{ __('Status — Terkirim ✓') }}</span>
        <h1 style="font-size:clamp(36px,5vw,56px);margin-bottom:16px;">{{ __('Terima kasih!') }}</h1>
        <p style="font-size:16px;color:var(--gray-600);margin-bottom:40px;">
            {{ __('Permintaan Anda sudah kami terima. Tim sales kami akan menghubungi Anda') }}
            {{ __('maksimal') }} <strong>1×24 {{ __('jam kerja') }}</strong> melalui email atau WhatsApp.
        </p>
        <div style="display:flex;gap:16px;justify-content:center;flex-wrap:wrap;">
            <a href="{{ route('home') }}" class="btn btn-outline">{{ __('← Kembali ke Beranda') }}</a>
            <a href="{{ route('portfolio.index') }}" class="btn">{{ __('Lihat Portofolio') }}</a>
        </div>
    </div>
</section>

@endsection
