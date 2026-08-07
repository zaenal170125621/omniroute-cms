@extends('layouts.public')

@section('title', __('Mulai Proyek') . ' — ' . setting('company_name', 'OmniRoute Studio'))
@section('meta_description', __('Pilih paket, isi form singkat — tim kami membalas dalam 1×24 jam kerja.'))

@section('content')

{{-- ============ ORDER HERO ============ --}}
<section class="order-hero">
    <div class="container">
        <div class="order-hero-grid">
            <div class="order-hero-main">
                <span class="section-label">{{ __('Order') }}</span>
                <h1>{{ __('Mulai proyek Anda') }}</h1>
                <p class="lead">{{ setting('order_note', 'Setelah mengirim, tim sales kami akan menghubungi Anda maksimal 1×24 jam kerja.') }}</p>
                <ul class="hero-trust" role="list">
                    <li><span class="tick" aria-hidden="true">✓</span> {{ __('Respon 1×24 jam kerja') }}</li>
                    <li><span class="tick" aria-hidden="true">✓</span> {{ __('Konsultasi gratis') }}</li>
                    <li><span class="tick" aria-hidden="true">✓</span> {{ __('120+ proyek selesai') }}</li>
                </ul>
            </div>
            <div class="order-hero-side" aria-hidden="true">
                <div class="hero-stat"><span class="hs-num">1×24</span><span class="hs-label">{{ __('jam waktu respons') }}</span></div>
                <div class="hero-stat"><span class="hs-num">4,9/5</span><span class="hs-label">{{ __('Rating Klien') }}</span></div>
                <div class="hero-stat"><span class="hs-num">120+</span><span class="hs-label">{{ __('Proyek Selesai') }}</span></div>
            </div>
        </div>
    </div>
</section>

{{-- ============ FORM + SUMMARY SIDEBAR ============ --}}
<section class="section order-section">
    <div class="container">
        <div class="order-layout">

            {{-- Kolom utama: stepper + form --}}
            <div class="order-main">

                {{-- Step indicator --}}
                <div class="order-stepper" role="tablist" aria-label="{{ __('Tahapan pemesanan') }}">
                    <div class="order-steps">
                        <button type="button" class="order-step active" data-step="0" role="tab" aria-selected="true">
                            <span class="step-dot">1</span>
                            <span class="step-label">{{ __('Pilih Paket') }}</span>
                        </button>
                        <button type="button" class="order-step" data-step="1" role="tab" aria-selected="false">
                            <span class="step-dot">2</span>
                            <span class="step-label">{{ __('Data Kontak') }}</span>
                        </button>
                        <button type="button" class="order-step" data-step="2" role="tab" aria-selected="false">
                            <span class="step-dot">3</span>
                            <span class="step-label">{{ __('Kebutuhan & Kirim') }}</span>
                        </button>
                    </div>
                </div>

                <form method="POST" action="{{ route('order.store') }}" id="order-form" novalidate>
                    @csrf
                    <input type="hidden" name="package" value="">

                    {{-- Honeypot anti-spam (disembunyikan dari manusia) --}}
                    <div class="hp-wrap" aria-hidden="true">
                        <label for="company_site">Website</label>
                        <input type="text" id="company_site" name="company_site" tabindex="-1" autocomplete="off">
                    </div>

                    {{-- STEP 1 — Pilih paket --}}
                    <div class="step-panel active">
                        <div class="panel-head">
                            <span class="section-label">{{ __('Pilih Paket') }}</span>
                            <h2>{{ __('Pilih paket sesuai kebutuhan Anda') }}</h2>
                            <p>{{ __('Klik salah satu paket — harga dapat disesuaikan dengan kebutuhan.') }}</p>
                        </div>
                        <div class="grid-3 packages">
                            @foreach ($packages as $package)
                                <div class="package-option {{ ($package['popular'] ?? false) ? 'popular' : '' }}" data-package="{{ $package['code'] }}" tabindex="0" role="radio" aria-checked="false" aria-label="{{ $package['name'] }}">
                                    @if ($package['popular'] ?? false)
                                        <span class="p-badge">{{ __('Paling Populer') }}</span>
                                    @endif
                                    <span class="p-num">{{ str_pad((string) $loop->iteration, 2, '0', STR_PAD_LEFT) }}</span>
                                    <div class="p-name">{{ $package['name'] }}</div>
                                    <div class="p-price">
                                        @if ($package['price'] !== 'Diskusi')
                                            <span class="p-price-from">{{ __('Mulai dari') }}</span>
                                        @endif
                                        <span class="p-price-value">{{ $package['price'] }}</span>
                                    </div>
                                    <div class="p-desc">{{ $package['desc'] }}</div>
                                    <ul class="package-features">
                                        @foreach (array_slice($package['features'], 0, 4) as $feature)
                                            <li>{{ $feature }}</li>
                                        @endforeach
                                        @if (count($package['features']) > 4)
                                            <li style="opacity:.55;font-style:italic;">+ {{ count($package['features']) - 4 }} {{ __('fitur lainnya — lihat halaman Harga') }}</li>
                                        @endif
                                    </ul>
                                </div>
                            @endforeach
                        </div>
                        @error('package') <div class="form-error">{{ $message }}</div> @enderror
                        <div class="form-error package-error" style="display:none;">{{ __('Pilih salah satu paket terlebih dahulu.') }}</div>
                        <div class="step-actions">
                            <span class="step-hint">{{ __('Yang Anda dapatkan') }} — {{ count($packages) }} {{ __('paket pilihan') }}</span>
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
                            <input type="text" id="name" name="name" class="form-control" value="{{ old('name') }}" placeholder="{{ __('Nama Anda') }}" required autocomplete="name">
                        </div>

                        <div class="form-grid-2">
                            <div class="form-group">
                                <label for="email">{{ __('Email') }} *</label>
                                <input type="email" id="email" name="email" class="form-control" value="{{ old('email') }}" placeholder="email@anda.com" required autocomplete="email">
                            </div>
                            <div class="form-group">
                                <label for="phone">{{ __('Telepon / WhatsApp') }} *</label>
                                <input type="text" id="phone" name="phone" class="form-control" value="{{ old('phone') }}" placeholder="08xx-xxxx-xxxx" required autocomplete="tel">
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="company">{{ __('Perusahaan') }} <span style="text-transform:none;font-weight:400;">{{ __('(opsional)') }}</span></label>
                            <input type="text" id="company" name="company" class="form-control" value="{{ old('company') }}" placeholder="{{ __('Nama perusahaan') }}" autocomplete="organization">
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

            {{-- Kolom samping: ringkasan sticky --}}
            <aside class="order-aside">
                <div class="summary-card">
                    <div class="summary-head">
                        <h3>{{ __('Ringkasan') }}</h3>
                        <span class="summary-step" id="summary-step">{{ __('Langkah') }} 1/3</span>
                    </div>
                    <div class="summary-body">
                        <div class="summary-row">
                            <span class="summary-label">{{ __('Paket') }}</span>
                            <span class="summary-value" id="summary-package">{{ __('Belum dipilih') }}</span>
                        </div>
                        <div class="summary-row">
                            <span class="summary-label">{{ __('Nama') }}</span>
                            <span class="summary-value" id="summary-name">—</span>
                        </div>
                        <div class="summary-row">
                            <span class="summary-label">{{ __('Email') }}</span>
                            <span class="summary-value" id="summary-email">—</span>
                        </div>
                        <div class="summary-row">
                            <span class="summary-label">{{ __('Estimasi Budget') }}</span>
                            <span class="summary-value" id="summary-budget">—</span>
                        </div>
                        <div class="summary-row">
                            <span class="summary-label">{{ __('Target Selesai') }}</span>
                            <span class="summary-value" id="summary-timeline">—</span>
                        </div>
                    </div>
                    <div class="summary-note">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true" style="flex-shrink:0;margin-top:2px;"><rect x="3" y="11" width="18" height="11" rx="2"/><path d="M7 11V7a5 5 0 0 1 10 0v4"/></svg>
                        <span>{{ __('Data Anda aman dan hanya dipakai tim sales untuk follow-up.') }}</span>
                    </div>
                </div>

                <div class="aside-help">
                    <h4>{{ __('Butuh bantuan?') }}</h4>
                    <p>{{ __('Tanya dulu sebelum order — kami bantu pilih paket yang tepat.') }}</p>
                    <a href="{{ route('contact') }}" class="btn btn-outline btn-sm btn-block">{{ __('Kontak Kami') }}</a>
                    @php $waLink = wa_link(__('Halo, saya ingin bertanya tentang layanan Anda.')); @endphp
                    @if ($waLink)
                        <a class="aside-wa" href="{{ $waLink }}" target="_blank" rel="noopener">
                            {{ __('Chat WhatsApp') }} →
                        </a>
                    @endif
                </div>
            </aside>

        </div>
    </div>
</section>

{{-- ============ NEXT STEPS ============ --}}
<section class="section next-steps-section">
    <div class="container">
        <div class="section-header">
            <div>
                <span class="section-label">{{ __('Proses') }}</span>
                <h2 class="section-title">{{ __('Bagaimana selanjutnya?') }}</h2>
            </div>
        </div>
        <div class="grid-3 next-steps">
            <div class="next-step">
                <span class="ns-num">01</span>
                <h3>{{ __('Tim sales membalas') }}</h3>
                <p>{{ __('Kami hubungi Anda maksimal 1×24 jam kerja — via WhatsApp atau email.') }}</p>
            </div>
            <div class="next-step">
                <span class="ns-num">02</span>
                <h3>{{ __('Discovery call & proposal') }}</h3>
                <p>{{ __('Diskusi singkat kebutuhan Anda, lalu kami kirim proposal & estimasi.') }}</p>
            </div>
            <div class="next-step">
                <span class="ns-num">03</span>
                <h3>{{ __('Kontrak & mulai pengerjaan') }}</h3>
                <p>{{ __('Setuju dengan proposal? Kami mulai desain dalam 1–2 hari kerja.') }}</p>
            </div>
        </div>
    </div>
</section>

@endsection
