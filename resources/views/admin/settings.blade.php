@extends('layouts.admin')

@section('title', 'Pengaturan')

@section('content')

<div class="panel">
    <div class="panel-header">
        <h3>Pengaturan Website</h3>
    </div>
    <div class="panel-body">
        <form method="POST" action="{{ route('admin.settings.update') }}">
            @csrf

            <div class="settings-grid">
                <div class="settings-section">Informasi Perusahaan</div>
                @foreach ([
                    'company_name' => 'Nama Perusahaan',
                    'tagline' => 'Tagline',
                    'logo_text' => 'Teks Logo',
                    'email' => 'Email',
                    'phone' => 'Telepon',
                    'address' => 'Alamat',
                    'whatsapp' => 'WhatsApp (format 62...)',
                    'instagram' => 'URL Instagram',
                    'linkedin' => 'URL LinkedIn',
                    'footer_text' => 'Teks Footer',
                ] as $key => $label)
                    <div class="form-group">
                        <label for="field-{{ $key }}">{{ $label }}</label>
                        <input type="text" id="field-{{ $key }}" name="{{ $key }}" class="form-control" value="{{ setting($key, '') }}">
                    </div>
                @endforeach

                <div class="settings-section">Hero Beranda</div>
                @foreach ([
                    'hero_badge' => 'Badge',
                    'hero_title' => 'Judul',
                    'hero_subtitle' => 'Subjudul',
                    'hero_cta_primary' => 'CTA Utama',
                    'hero_cta_secondary' => 'CTA Sekunder',
                ] as $key => $label)
                    <div class="form-group">
                        <label for="field-{{ $key }}">{{ $label }}</label>
                        @if ($key === 'hero_title')
                            <textarea id="field-{{ $key }}" name="{{ $key }}" class="form-control" rows="2">{{ setting($key, '') }}</textarea>
                        @elseif ($key === 'hero_subtitle')
                            <textarea id="field-{{ $key }}" name="{{ $key }}" class="form-control" rows="3">{{ setting($key, '') }}</textarea>
                        @else
                            <input type="text" id="field-{{ $key }}" name="{{ $key }}" class="form-control" value="{{ setting($key, '') }}">
                        @endif
                    </div>
                @endforeach

                <div class="settings-section">SEO Global</div>
                <div class="form-group">
                    <label for="field-seo_title">Judul Default</label>
                    <input type="text" id="field-seo_title" name="seo_title" class="form-control" value="{{ setting('seo_title', '') }}">
                </div>
                <div class="form-group">
                    <label for="field-seo_description">Deskripsi Default</label>
                    <textarea id="field-seo_description" name="seo_description" class="form-control" rows="3">{{ setting('seo_description', '') }}</textarea>
                </div>

                <div class="settings-section">Lainnya</div>
                <div class="form-group full">
                    <label for="field-order_note">Catatan Halaman Order</label>
                    <textarea id="field-order_note" name="order_note" class="form-control" rows="2">{{ setting('order_note', '') }}</textarea>
                </div>
                <div class="form-group full">
                    <label for="field-lead_notify_email">Email Notifikasi Lead Baru (Sales)</label>
                    <input type="email" id="field-lead_notify_email" name="lead_notify_email" class="form-control" value="{{ setting('lead_notify_email', '') }}">
                    <div style="font-size:11px;color:var(--muted);margin-top:4px;">Kosongkan untuk menonaktifkan notifikasi. Pastikan konfigurasi SMTP di .env sudah diisi agar email benar-benar terkirim.</div>
                </div>
                <div class="form-group full">
                    <label for="field-analytics_head">Kode Analytics (Header)</label>
                    <textarea id="field-analytics_head" name="analytics_head" class="form-control" rows="3" placeholder="&lt;script async src=&quot;https://www.googletagmanager.com/gtag/js?id=G-XXXXXXX&quot;&gt;&lt;/script&gt;">{{ setting('analytics_head', '') }}</textarea>
                    <div style="font-size:11px;color:var(--muted);margin-top:4px;">Kode Google Analytics / Tag Manager (atau piksel lainnya) akan disisipkan tepat sebelum &lt;/head&gt; di semua halaman publik.</div>
                </div>
            </div>

            <div class="form-actions">
                <button type="submit" class="btn">Simpan Pengaturan</button>
            </div>
        </form>
    </div>
</div>

@endsection
