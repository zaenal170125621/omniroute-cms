@extends('layouts.public')

@section('title', $portfolio->title . ' — Portofolio ' . setting('company_name', 'OmniRoute Studio'))
@section('meta_description', \Illuminate\Support\Str::limit($portfolio->description, 160))

@section('content')

<section class="detail-hero">
    <div class="container">
        <span class="section-label">Portofolio — {{ $portfolio->categoryLabel() }}</span>
        <h1>{{ $portfolio->title }}</h1>
        <div class="detail-meta">
            @if ($portfolio->year)
                <span>Tahun <b>{{ $portfolio->year }}</b></span>
            @endif
            <span>Kategori <b>{{ $portfolio->categoryLabel() }}</b></span>
        </div>
    </div>
</section>

<section class="section">
    <div class="container">
        @if ($portfolio->cover_image)
            <img src="{{ cover_url($portfolio->cover_image) }}" alt="{{ $portfolio->title }}" style="width:100%;aspect-ratio:16/9;object-fit:cover;margin-bottom:56px;border:1px solid var(--gray-200);">
        @else
            {!! swiss_block($portfolio->cover_color, $portfolio->title, '00') !!}
        @endif

        <div style="display:grid;grid-template-columns:1.6fr 1fr;gap:56px;align-items:start;">
            <div class="prose">{!! markdown($portfolio->description) !!}</div>

            <div style="position:sticky;top:88px;">
                <div class="card" style="padding:28px;">
                    @if ($portfolio->tech_stack)
                        <h4 style="font-size:12px;font-weight:700;letter-spacing:0.1em;text-transform:uppercase;color:var(--gray-600);margin-bottom:12px;">Teknologi</h4>
                        <div class="tech-tags" style="margin:0 0 24px;">
                            @foreach ($portfolio->tech_stack as $tech)
                                <span class="tech-tag">{{ $tech }}</span>
                            @endforeach
                        </div>
                    @endif
                    @if ($portfolio->link)
                        <a href="{{ $portfolio->link }}" target="_blank" rel="noopener" class="btn btn-block" style="margin-bottom:12px;">Kunjungi Live ↗</a>
                    @endif
                    <a href="{{ route('order') }}" class="btn btn-outline btn-block">Ingin Serupa? →</a>
                </div>
            </div>
        </div>
    </div>
</section>

@endsection
