@extends('layouts.public')

@section('title', __('FAQ') . ' — ' . setting('company_name', 'OmniRoute Studio'))
@section('meta_description', __('Proses, biaya, timeline, dan dukungan — dijawab langsung. Tidak menemukan jawabannya?'))

@push('head')
    <script type="application/ld+json">
        {
            "@context": "https://schema.org",
            "@type": "FAQPage",
            "mainEntity": [
                @foreach ($faqs as $index => $faq)
                    {
                        "@type": "Question",
                        "name": {{ json_encode(__($faq['question'])) }},
                        "acceptedAnswer": {
                            "@type": "Answer",
                            "text": {{ json_encode(__($faq['answer'])) }}
                        }
                    }{{ $index < count($faqs) - 1 ? ',' : '' }}
                @endforeach
            ]
        }
    </script>
@endpush

@section('content')

<section class="page-hero">
    <div class="container">
        <span class="section-label">{{ __('FAQ') }}</span>
        <h1>{{ __('Pertanyaan yang sering diajukan') }}</h1>
        <p class="lead">{{ __('Proses, biaya, timeline, dan dukungan — dijawab langsung. Tidak menemukan jawabannya?') }} <a href="{{ route('contact') }}" style="text-decoration:underline;">{{ __('Hubungi kami') }} →</a></p>
    </div>
</section>

<section class="section">
    <div class="container container-narrow">
        <div class="faq-list">
            @foreach ($faqs as $faq)
                <details class="faq-item" @if ($loop->first) open @endif>
                    <summary>{{ __($faq['question']) }}</summary>
                    <div class="faq-answer">{{ __($faq['answer']) }}</div>
                </details>
            @endforeach
        </div>
    </div>
</section>

<section class="cta-band">
    <div class="container">
        <h2>{{ __('Masih ragu? Mari bicara') }}</h2>
        <p>{{ __('Ceritakan kebutuhan Anda — kami bantu temukan solusi yang tepat.') }}</p>
        <a href="{{ route('order') }}" class="btn btn-light">{{ __('Mulai Proyek') }} →</a>
    </div>
</section>

@endsection
