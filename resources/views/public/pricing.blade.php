@extends('layouts.public')

@section('title', __('Harga Paket') . ' — ' . setting('company_name', 'OmniRoute Studio'))
@section('meta_description', __('Pilih paket website yang tepat untuk kebutuhan bisnis Anda. Mulai dari Rp 3.500.000.'))

@push('head')
<style>
  /* Inline critical styles for comparison table toggle */
  .comparison-table { display: none; }
  .comparison-table.open { display: block; animation: fadeIn 0.2s ease; }
  @keyframes fadeIn { from { opacity: 0; transform: translateY(-8px); } to { opacity: 1; transform: translateY(0); } }
</style>
@endpush

@section('content')

{{-- ============ PRICING HERO ============ --}}
<section class="page-hero">
    <div class="container">
        <span class="section-label">{{ __('Harga Paket') }}</span>
        <h1>{{ __('Pilih paket yang tepat untuk Anda') }}</h1>
        <p class="lead">{{ __('Semua paket mencakup desain custom, domain & hosting 1 tahun, dan support pasca launch.') }}</p>
    </div>
</section>

{{-- ============ PRICING GRID ============ --}}
<section class="section">
    <div class="container">
        <div class="pricing-grid" id="pricing-grid">
            @foreach ($packages as $package)
                <div class="pricing-col {{ $package['popular'] ?? false ? 'popular' : '' }}" data-package="{{ $package['code'] }}">
                    @if ($package['popular'] ?? false)
                        <span class="p-badge">{{ __('Paling Populer') }}</span>
                    @endif
                    <div class="p-name">{{ $package['name'] }}</div>
                    <div class="p-price">
                        @if ($package['price'] !== 'Diskusi')
                            <span class="p-price-from">{{ __('Mulai dari') }}</span>
                        @endif
                        <span class="p-price-value">{{ $package['price'] }}</span>
                        @if ($package['price'] !== 'Diskusi')
                            <span class="price-period">{{ __('sekali bayar') }}</span>
                        @endif
                    </div>
                    <div class="p-desc">{{ $package['desc'] }}</div>

                    <ul>
                        @foreach ($package['features'] as $feature)
                            <li>{{ $feature }}</li>
                        @endforeach
                    </ul>

                    <a href="{{ route('order') }}?package={{ $package['code'] }}" class="btn {{ ($package['popular'] ?? false) ? '' : 'btn-outline' }}" data-cta-package="{{ $package['code'] }}">
                        @if ($package['popular'] ?? false)
                            {{ __('Pilih Paket Ini') }}
                        @else
                            {{ __('Pilih Paket') }}
                        @endif
                    </a>
                </div>
            @endforeach
        </div>

        {{-- Comparison Toggle --}}
        <div class="comparison-toggle">
            <button type="button" class="btn btn-outline" id="toggle-comparison" aria-expanded="false" aria-controls="comparison-table">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true" style="margin-right:8px;vertical-align:-3px;"><rect x="3" y="3" width="7" height="9" rx="1"/><rect x="14" y="3" width="7" height="5" rx="1"/><rect x="14" y="12" width="7" height="9" rx="1"/><rect x="3" y="16" width="7" height="5" rx="1"/></svg>
                {{ __('Bandingkan Fitur Lengkap') }}
            </button>
        </div>

        {{-- Comparison Table --}}
        <div class="comparison-table" id="comparison-table" role="region" aria-label="{{ __('Perbandingan fitur paket') }}">
            <table>
                <thead>
                    <tr>
                        <th scope="col">{{ __('Fitur') }}</th>
                        @foreach ($packages as $package)
                            <th scope="col" class="{{ ($package['popular'] ?? false) ? 'popular-column' : '' }}">
                                {{ $package['name'] }}
                                @if ($package['popular'] ?? false)
                                    <span class="pill" style="margin-left:8px;font-size:10px;padding:2px 8px;background:var(--accent);color:var(--white);">{{ __('Populer') }}</span>
                                @endif
                            </th>
                        @endforeach
                    </tr>
                </thead>
                <tbody>
                    @php
                        // Collect all unique features
                        $allFeatures = [];
                        foreach ($packages as $package) {
                            foreach ($package['features'] as $feature) {
                                $allFeatures[$feature] = true;
                            }
                        }
                        $allFeatures = array_keys($allFeatures);
                    @endphp
                    @foreach ($allFeatures as $feature)
                        <tr>
                            <td class="feature-name">{{ $feature }}</td>
                            @foreach ($packages as $package)
                                <td>
                                    @if (in_array($feature, $package['features']))
                                        <span class="check" aria-label="{{ __('Tersedia') }}">✓</span>
                                    @else
                                        <span class="cross" aria-label="{{ __('Tidak tersedia') }}">—</span>
                                    @endif
                                </td>
                            @endforeach
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</section>

{{-- ============ FAQ ACCORDION ============ --}}
<section class="section" style="background:var(--gray-50);">
    <div class="container">
        <div class="section-header">
            <div>
                <span class="section-label">{{ __('Bantuan') }}</span>
                <h2 class="section-title">{{ __('Pertanyaan yang Sering Diajukan') }}</h2>
            </div>
        </div>

        <div class="pricing-faq">
            <div class="faq-list">
                <details class="faq-item">
                    <summary>{{ __('Apakah harga sudah include domain & hosting?') }}</summary>
                    <div class="faq-answer">{{ __('Ya, semua paket include domain (.com/.id) dan hosting 1 tahun. Perpanjangan domain & hosting tahun kedua seharga Rp 350.000/tahun.') }}</div>
                </details>

                <details class="faq-item">
                    <summary>{{ __('Berapa lama proses pembuatan website?') }}</summary>
                    <div class="faq-answer">{{ __('Starter: 5–7 hari kerja. Business: 2–3 minggu. Custom: tergantung kompleksitas, biasanya 4–8 minggu. Timeline pasti diberikan setelah discovery call.') }}</div>
                </details>

                <details class="faq-item">
                    <summary>{{ __('Apakah bisa request revisi desain?') }}</summary>
                    <div class="faq-answer">{{ __('Bisa. Starter: 1x revisi. Business: 2x revisi. Custom: unlimited revisi saat tahap desain. Kami tidak lanjut ke development sebelum Anda approve desain.') }}</div>
                </details>

                <details class="faq-item">
                    <summary>{{ __('Apakah website sudah SEO friendly?') }}</summary>
                    <div class="faq-answer">{{ __('Ya. Semua paket include: meta tags otomatis, sitemap.xml, robots.txt, schema.org markup, heading structure yang benar, dan kecepatan loading optimal (90+ PageSpeed).') }}</div>
                </details>

                <details class="faq-item">
                    <summary>{{ __('Bagaimana cara pembayarannya?') }}</summary>
                    <div class="faq-answer">{{ __('DP 50% saat kontrak ditandatangani, sisanya 50% saat website launch. Pembayaran via transfer bank. Untuk paket Custom > Rp 50jt, tersedia cicilan 3x tanpa bunga.') }}</div>
                </details>

                <details class="faq-item">
                    <summary>{{ __('Apakah ada garansi pasca launch?') }}</summary>
                    <div class="faq-answer">{{ __('Ya. Support gratis: Starter 30 hari, Business 60 hari, Custom 90 hari. Termasuk: perbaikan bug, update keamanan minor, konsultasi konten. Maintenance bulanan opsional tersedia.') }}</div>
                </details>

                <details class="faq-item">
                    <summary>{{ __('Bisa tidak website dikembangkan sendiri nanti?') }}</summary>
                    <div class="faq-answer">{{ __('Bisa. Kami gunakan Laravel + Filament/WordPress — kode bersih, terdokumentasi, dan Anda dapat akses penuh ke source code & database. Kami juga provide handover session.') }}</div>
                </details>
            </div>
        </div>
    </div>
</section>

{{-- ============ HELP CARDS ============ --}}
<section class="section">
    <div class="container">
        <div class="section-header">
            <div>
                <span class="section-label">{{ __('Bantuan') }}</span>
                <h2 class="section-title">{{ __('Butuh bantuan memilih?') }}</h2>
            </div>
        </div>

        <div class="grid-3" style="margin-top:32px;">
            <div class="card">
                <div class="card-body">
                    <div class="icon icon-img" style="margin-bottom:16px;">
                        <svg viewBox="0 0 24 24" width="28" height="28" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/><polyline points="7 10 12 15 17 10"/><line x1="12" y1="15" x2="12" y2="3"/></svg>
                    </div>
                    <h3>{{ __('Konsultasi Gratis') }}</h3>
                    <p>{{ __('Belum yakin paket mana yang cocok? Jangan ragu untuk konsultasi dulu — kami bantu analisis kebutuhan tanpa biaya.') }}</p>
                </div>
            </div>

            <div class="card">
                <div class="card-body">
                    <div class="icon icon-img" style="margin-bottom:16px;">
                        <svg viewBox="0 0 24 24" width="28" height="28" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true"><circle cx="12" cy="12" r="10"/><path d="M12 16v-4"/><path d="M12 8h.01"/></svg>
                    </div>
                    <h3>{{ __('Custom Quote') }}</h3>
                    <p>{{ __('Kebutuhan unik? Paket Custom memungkinkan fitur apapun — e-commerce, booking system, dashboard, API, dll.') }}</p>
                </div>
            </div>

            <div class="card">
                <div class="card-body">
                    <div class="icon icon-img" style="margin-bottom:16px;">
                        <svg viewBox="0 0 24 24" width="28" height="28" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/></svg>
                    </div>
                    <h3>{{ __('Garansi Puas') }}</h3>
                    <p>{{ __('Revisi desain hingga puas saat tahap desain. Kami tidak lanjut ke development sebelum Anda approve.') }}</p>
                </div>
            </div>
        </div>
    </div>
</section>

{{-- ============ CTA ============ --}}
<section class="cta-band">
    <div class="container">
        <h2>{{ __('Siap memulai proyek Anda?') }}</h2>
        <p>{{ __('Pilih paket, isi formulir singkat, dan tim kami akan menghubungi Anda dalam 1×24 jam kerja.') }}</p>
        <a href="{{ route('order') }}" class="btn btn-light">{{ __('Mulai Proyek') }} →</a>
    </div>
</section>

{{-- ============ STICKY MOBILE CTA ============ --}}
<div class="pricing-sticky-cta" id="pricing-sticky-cta" role="complementary" aria-label="{{ __('Quick action') }}">
    <a href="{{ route('order') }}?package=business" class="btn btn-sm" style="flex:1;">{{ __('Mulai Bisnis') }}</a>
    <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', setting('whatsapp', '628123456789')) }}" target="_blank" rel="noopener" class="btn btn-outline btn-sm" style="flex:1;display:flex;align-items:center;justify-content:center;gap:6px;">
        <svg width="18" height="18" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/></svg>
        {{ __('Chat WA') }}
    </a>
</div>

@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
  // Comparison table toggle
  const toggleBtn = document.getElementById('toggle-comparison');
  const comparisonTable = document.getElementById('comparison-table');
  
  if (toggleBtn && comparisonTable) {
    toggleBtn.addEventListener('click', function() {
      const isOpen = comparisonTable.classList.toggle('open');
      toggleBtn.setAttribute('aria-expanded', isOpen);
      toggleBtn.innerHTML = isOpen
        ? '<svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true" style="margin-right:8px;vertical-align:-3px;"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg> {{ __('Sembunyikan Perbandingan') }}'
        : '<svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true" style="margin-right:8px;vertical-align:-3px;"><rect x="3" y="3" width="7" height="9" rx="1"/><rect x="14" y="3" width="7" height="5" rx="1"/><rect x="14" y="12" width="7" height="9" rx="1"/><rect x="3" y="16" width="7" height="5" rx="1"/></svg> {{ __('Bandingkan Fitur Lengkap') }}';
    });
  }

  // Sticky mobile CTA show/hide on scroll
  const stickyCta = document.getElementById('pricing-sticky-cta');
  const pricingGrid = document.getElementById('pricing-grid');
  
  if (stickyCta && pricingGrid) {
    const observer = new IntersectionObserver(function(entries) {
      entries.forEach(function(entry) {
        if (!entry.isIntersecting) {
          stickyCta.classList.add('visible');
        } else {
          stickyCta.classList.remove('visible');
        }
      });
    }, { rootMargin: '-100px 0px 0px 0px' });
    
    observer.observe(pricingGrid);
  }

  // Smooth scroll for anchor links
  document.querySelectorAll('a[href^="#"]').forEach(function(anchor) {
    anchor.addEventListener('click', function(e) {
      const target = document.querySelector(this.getAttribute('href'));
      if (target) {
        e.preventDefault();
        target.scrollIntoView({ behavior: 'smooth', block: 'start' });
      }
    });
  });

  // Add hover effect to pricing cards (touch-friendly)
  const pricingCards = document.querySelectorAll('.pricing-col');
  pricingCards.forEach(function(card) {
    card.addEventListener('touchstart', function() {}, { passive: true });
  });
});
</script>
@endpush