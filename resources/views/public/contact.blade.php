@extends('layouts.public')

@section('title', __('Kontak') . ' — ' . setting('company_name', 'OmniRoute Studio'))

@section('content')

<section class="page-hero">
    <div class="container">
        <span class="section-label">{{ __('Kontak') }}</span>
        <h1>{{ __('Mari bicara') }}</h1>
        <p class="lead">{{ __('Punya pertanyaan atau ingin konsultasi? Kirim pesan — kami balas dalam 1×24 jam kerja.') }}</p>
    </div>
</section>

<section class="section">
    <div class="container">
        <div style="display:grid;grid-template-columns:1.4fr 1fr;gap:56px;align-items:start;">

            <form method="POST" action="{{ route('contact.store') }}">
                @csrf
                <div class="form-group">
                    <label for="name">{{ __('Nama Lengkap') }} *</label>
                    <input type="text" id="name" name="name" class="form-control" value="{{ old('name') }}" required>
                    @error('name') <div class="form-error">{{ $message }}</div> @enderror
                </div>

                <div style="display:grid;grid-template-columns:1fr 1fr;gap:16px;">
                    <div class="form-group">
                        <label for="email">{{ __('Email') }} *</label>
                        <input type="email" id="email" name="email" class="form-control" value="{{ old('email') }}" required>
                        @error('email') <div class="form-error">{{ $message }}</div> @enderror
                    </div>
                    <div class="form-group">
                        <label for="phone">{{ __('Telepon / WhatsApp') }}</label>
                        <input type="text" id="phone" name="phone" class="form-control" value="{{ old('phone') }}">
                    </div>
                </div>

                <div class="form-group">
                    <label for="company">{{ __('Perusahaan') }}</label>
                    <input type="text" id="company" name="company" class="form-control" value="{{ old('company') }}">
                </div>

                <div class="form-group">
                    <label for="message">{{ __('Pesan') }} *</label>
                    <textarea id="message" name="message" class="form-control" required>{{ old('message') }}</textarea>
                    @error('message') <div class="form-error">{{ $message }}</div> @enderror
                </div>

                {{-- Honeypot anti-spam (disembunyikan dari manusia) --}}
                <div class="hp-wrap" aria-hidden="true">
                    <label for="company_site">Website</label>
                    <input type="text" id="company_site" name="company_site" tabindex="-1" autocomplete="off">
                </div>

                <button type="submit" class="btn">{{ __('Kirim Pesan') }} →</button>
            </form>

            <div>
                <div class="card" style="padding:32px;">
                    <h3 style="font-size:18px;margin-bottom:20px;">{{ __('Informasi kontak') }}</h3>
                    <div class="detail-meta" style="flex-direction:column;gap:16px;margin-top:0;">
                        <span>{{ __('Email') }}<br><b>{{ setting('email', '') }}</b></span>
                        <span>{{ __('Telepon') }}<br><b>{{ setting('phone', '') }}</b></span>
                        <span>{{ __('Alamat') }}<br><b>{{ setting('address', '') }}</b></span>
                    </div>
                    <div style="margin-top:24px;display:flex;gap:12px;">
                        @if (setting('instagram'))
                            <a href="{{ setting('instagram') }}" target="_blank" rel="noopener" class="btn btn-outline btn-sm">Instagram</a>
                        @endif
                        @if (setting('linkedin'))
                            <a href="{{ setting('linkedin') }}" target="_blank" rel="noopener" class="btn btn-outline btn-sm">LinkedIn</a>
                        @endif
                    </div>
                </div>

                <div class="card" style="padding:32px;margin-top:16px;">
                    <h3 style="font-size:18px;margin-bottom:8px;">{{ __('Ingin order langsung?') }}</h3>
                    <p style="font-size:13px;color:var(--gray-600);margin-bottom:16px;">{{ __('Pilih paket dan isi kebutuhan Anda di halaman order.') }}</p>
                    <a href="{{ route('order') }}" class="btn btn-block">{{ __('Mulai Proyek') }} →</a>
                </div>
            </div>

        </div>
    </div>
</section>

@endsection
