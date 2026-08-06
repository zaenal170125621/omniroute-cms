@extends('layouts.public')

@section('title', '404 — ' . setting('company_name', 'OmniRoute Studio'))

@section('content')

<section class="section" style="padding-top:140px;">
    <div class="container" style="max-width:640px;text-align:center;">
        <div class="error-code" aria-hidden="true">404</div>
        <h1 style="font-size:clamp(30px,4.5vw,44px);margin-bottom:16px;">{{ __('Halaman tidak ditemukan') }}</h1>
        <p style="font-size:16px;color:var(--gray-600);margin:0 auto 40px;max-width:460px;">
            {{ __('Halaman yang Anda cari mungkin sudah dipindah atau dihapus. Mari kembali ke jalur yang benar.') }}
        </p>
        <div style="display:flex;gap:16px;justify-content:center;flex-wrap:wrap;">
            <a href="{{ route('home') }}" class="btn">{{ __('← Beranda') }}</a>
            <a href="{{ route('contact') }}" class="btn btn-outline">{{ __('Kontak Kami') }}</a>
        </div>
    </div>
</section>

@endsection
