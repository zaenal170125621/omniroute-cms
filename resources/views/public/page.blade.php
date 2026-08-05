@extends('layouts.public')

@section('title', $page->title . ' — ' . setting('company_name', 'OmniRoute Studio'))
@section('meta_description', $page->seo_description)

@section('content')

<section class="page-hero">
    <div class="container">
        <span class="section-label">{{ $page->title }}</span>
        <h1>{{ $page->title }}</h1>
    </div>
</section>

<section class="section">
    <div class="container">
        <div class="prose {{ $page->slug === 'about' ? 'prose--wide' : '' }}">{!! markdown($page->content) !!}</div>
    </div>
</section>

@endsection
