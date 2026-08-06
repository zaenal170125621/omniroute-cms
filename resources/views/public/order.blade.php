@extends('layouts.public')

@section('title', __('Mulai Proyek') . ' — ' . setting('company_name', 'OmniRoute Studio'))

@section('content')

<section class="page-hero">
    <div class="container">
        <span class="section-label">{{ __('Order') }}</span>
        <h1>{{ __('Mulai proyek Anda') }}</h1>
        <p class="lead">{{ setting('order_note', 'Setelah mengirim, tim sales kami akan menghubungi Anda maksimal 1×24 jam kerja.') }}</p>
    </div>
</section>

<section class="section">
    <div class="container" style="max-width:860px;">

        <div class="order-steps">
            <div class="order-step"><span class="step-dot">1</span><span class="step-label">{{ __('Pilih Paket') }}</span></div>
            <div class="order-step"><span class="step-dot">2</span><span class="step-label">{{ __('Data Kontak') }}</span></div>
            <div class="order-step"><span class="step-dot">3</span><span class="step-label">{{ __('Kebutuhan & Kirim') }}</span></div>
        </div>

        <form method="POST" action="{{ route('order.store') }}" id="order-form">
            @csrf
            <input type="hidden" name="package" value="">

            {{-- Honeypot anti-spam (disembunyikan dari manusia) --}}
            <div class="hp-wrap" aria-hidden="true">
                <label for="company_site">Website</label>
                <input type="text" id="company_site" name="company_site" tabindex="-1" autocomplete="off">
            </div>

            {{-- STEP 1 — Pilih paket --}}
            <div class="step-panel">
                <div class="panel-head">
                    <span class="section-label">{{ __('Pilih Paket') }}</span>
                    <h2>{{ __('Pilih paket sesuai kebutuhan Anda') }}</h2>
                    <p>{{ __('Klik salah satu paket — harga dapat disesuaikan dengan kebutuhan.') }}</p>
                </div>
                <div class="grid-3">
                    @foreach ($packages as $package)
                        <div class="package-option" data-package="{{ $package['code'] }}" tabindex="0">
                            <span class="p-num">{{ str_pad((string) $loop->iteration, 2, '0', STR_PAD_LEFT) }}</span>
                            <div class="p-name">{{ $package['name'] }}</div>
                            <div class="p-price">{{ $package['price'] }}</div>
                            <div class="p-desc">{{ $package['desc'] }}</div>
                        </div>
                    @endforeach
                </div>
                @error('package') <div class="form-error">{{ $message }}</div> @enderror
                <div class="form-error package-error" style="display:none;">{{ __('Pilih salah satu paket terlebih dahulu.') }}</div>
                <div class="step-actions">
                    <span></span>
                    <button type="button" class="btn" data-next>{{ __('Lanjut') }} →</button>
                </div>
            </div>

            {{-- STEP 2 — Data kontak --}}
            <div class="step-panel">
                <div class="panel-head">
                    <span class="section-label">{{ __('Data Kontak') }}</span>
                    <h2>{{ __('Lengkapi data kontak Anda') }}</h2>
                    <p>{{ __('Data Anda aman dan hanya digunakan untuk follow-up.') }}</p>
                </div>
                <div class="form-group">
                    <label for="name">{{ __('Nama Lengkap') }} *</label>
                    <input type="text" id="name" name="name" class="form-control" value="{{ old('name') }}" required>
                </div>

                <div class="form-grid-2">
                    <div class="form-group">
                        <label for="email">{{ __('Email') }} *</label>
                        <input type="email" id="email" name="email" class="form-control" value="{{ old('email') }}" required>
                    </div>
                    <div class="form-group">
                        <label for="phone">{{ __('Telepon / WhatsApp') }} *</label>
                        <input type="text" id="phone" name="phone" class="form-control" value="{{ old('phone') }}" required>
                    </div>
                </div>

                <div class="form-group">
                    <label for="company">{{ __('Perusahaan') }} <span style="text-transform:none;font-weight:400;">{{ __('(opsional)') }}</span></label>
                    <input type="text" id="company" name="company" class="form-control" value="{{ old('company') }}">
                </div>

                <div class="step-actions">
                    <button type="button" class="btn btn-outline" data-prev>{{ __('← Kembali') }}</button>
                    <button type="button" class="btn" data-next>{{ __('Lanjut') }} →</button>
                </div>
            </div>

            {{-- STEP 3 — Kebutuhan & kirim --}}
            <div class="step-panel">
                <div class="panel-head">
                    <span class="section-label">{{ __('Kebutuhan & Kirim') }}</span>
                    <h2>{{ __('Ceritakan kebutuhan proyek Anda') }}</h2>
                    <p>{{ __('Semakin detail, semakin akurat proposal yang kami buat.') }}</p>
                </div>
                <div class="form-grid-2">
                    <div class="form-group">
                        <label for="service_id">{{ __('Layanan Utama') }}</label>
                        <select id="service_id" name="service_id" class="form-control">
                            <option value="">— {{ __('Pilih layanan') }} —</option>
                            @foreach ($services as $service)
                                <option value="{{ $service->id }}" @selected(old('service_id') == $service->id)>{{ $service->title }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="budget">{{ __('Estimasi Budget') }}</label>
                        <select id="budget" name="budget" class="form-control">
                            <option value="">— Pilih budget —</option>
                            <option value="< Rp 5 juta" @selected(old('budget') == '< Rp 5 juta')>&lt; Rp 5 juta</option>
                            <option value="Rp 5–10 juta" @selected(old('budget') == 'Rp 5–10 juta')>Rp 5–10 juta</option>
                            <option value="Rp 10–25 juta" @selected(old('budget') == 'Rp 10–25 juta')>Rp 10–25 juta</option>
                            <option value="> Rp 25 juta" @selected(old('budget') == '> Rp 25 juta')>&gt; Rp 25 juta</option>
                        </select>
                    </div>
                </div>

                <div class="form-group">
                    <label for="timeline">{{ __('Target Selesai') }}</label>
                    <select id="timeline" name="timeline" class="form-control">
                        <option value="">— Pilih target —</option>
                        <option value="≤ 1 minggu" @selected(old('timeline') == '≤ 1 minggu')>≤ 1 minggu</option>
                        <option value="2–3 minggu" @selected(old('timeline') == '2–3 minggu')>2–3 minggu</option>
                        <option value="1–2 bulan" @selected(old('timeline') == '1–2 bulan')>1–2 bulan</option>
                        <option value="Fleksibel" @selected(old('timeline') == 'Fleksibel')>Fleksibel</option>
                    </select>
                </div>

                <div class="form-group">
                    <label for="message">{{ __('Ceritakan kebutuhan Anda') }} <span style="text-transform:none;font-weight:400;">{{ __('(opsional)') }}</span></label>
                    <textarea id="message" name="message" class="form-control" placeholder="{{ __('Contoh: butuh company profile untuk perusahaan konstruksi, 6 halaman, dengan portofolio proyek...') }}">{{ old('message') }}</textarea>
                </div>

                <div class="step-actions">
                    <button type="button" class="btn btn-outline" data-prev>{{ __('← Kembali') }}</button>
                    <button type="submit" class="btn">{{ __('Kirim Permintaan') }} →</button>
                </div>
            </div>
        </form>
    </div>
</section>

@endsection
