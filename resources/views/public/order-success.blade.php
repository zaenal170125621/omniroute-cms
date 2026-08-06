@extends('layouts.public')

@section('title', __('Permintaan Terkirim') . ' — ' . setting('company_name', 'OmniRoute Studio'))

@section('content')

<section class="section" style="padding-top:120px;">
    <div class="container" style="max-width:720px;text-align:center;">
        <div class="success-check" aria-hidden="true">✓</div>
        <span class="hero-badge" style="border-color:var(--black);">{{ __('Status — Terkirim ✓') }}</span>
        <h1 style="font-size:clamp(36px,5vw,56px);margin-bottom:16px;">{{ __('Terima kasih!') }}</h1>
        <p style="font-size:16px;color:var(--gray-600);margin:0 auto;max-width:520px;">
            {{ __('Permintaan Anda sudah kami terima. Tim sales kami akan menghubungi Anda') }}
            {{ __('maksimal') }} <strong>1×24 {{ __('jam kerja') }}</strong> melalui email atau WhatsApp.
        </p>

        <div class="grid-3 success-steps" style="margin:48px 0;text-align:left;">
            <div class="card" style="padding:24px;border-radius:var(--radius-xl);">
                <div class="step-num">1</div>
                <h4 style="font-size:15px;font-weight:800;margin:14px 0 6px;">{{ __('Cek email / WhatsApp Anda') }}</h4>
                <p style="font-size:13px;color:var(--gray-600);margin:0;">{{ __('Kami kirim ringkasan permintaan dan timeline respons.') }}</p>
            </div>
            <div class="card" style="padding:24px;border-radius:var(--radius-xl);">
                <div class="step-num">2</div>
                <h4 style="font-size:15px;font-weight:800;margin:14px 0 6px;">{{ __('Discovery call') }}</h4>
                <p style="font-size:13px;color:var(--gray-600);margin:0;">{{ __('Diskusi singkat untuk memahami kebutuhan Anda lebih dalam.') }}</p>
            </div>
            <div class="card" style="padding:24px;border-radius:var(--radius-xl);">
                <div class="step-num">3</div>
                <h4 style="font-size:15px;font-weight:800;margin:14px 0 6px;">{{ __('Proposal & estimasi') }}</h4>
                <p style="font-size:13px;color:var(--gray-600);margin:0;">{{ __('Kami kirim proposal, timeline, dan penawaran sesuai kebutuhan.') }}</p>
            </div>
        </div>

        <div style="display:flex;gap:16px;justify-content:center;flex-wrap:wrap;">
            <a href="{{ route('home') }}" class="btn btn-outline">{{ __('← Kembali ke Beranda') }}</a>
            <a href="{{ route('portfolio.index') }}" class="btn">{{ __('Lihat Portofolio') }}</a>
        </div>
    </div>
</section>

@endsection
