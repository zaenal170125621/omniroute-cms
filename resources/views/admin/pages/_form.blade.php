@php
    $page = $page ?? null;
@endphp

<div class="form-grid">
    <div class="form-group">
        <label for="title">Judul Halaman *</label>
        <input type="text" id="title" name="title" class="form-control" value="{{ old('title', $page?->title) }}" required>
        @error('title') <div class="form-error">{{ $message }}</div> @enderror
    </div>
    <div class="form-group">
        <label for="slug">Slug *</label>
        <input type="text" id="slug" name="slug" class="form-control" value="{{ old('slug', $page?->slug) }}" placeholder="about, pricing, privacy...">
        <div class="form-hint">Menjadi URL: /{{ old('slug', $page?->slug ?? 'slug') }}</div>
        @error('slug') <div class="form-error">{{ $message }}</div> @enderror
    </div>
</div>

<div class="form-group">
    <label for="content">Isi Halaman *</label>
    <textarea id="content" name="content" class="form-control" rows="16" required>{{ old('content', $page?->content) }}</textarea>
    <div class="form-hint">Format sederhana: "# Judul" untuk heading, "- item" untuk list, "> teks" untuk kutipan.</div>
    @error('content') <div class="form-error">{{ $message }}</div> @enderror
</div>

<div class="form-grid">
    <div class="form-group">
        <label for="seo_title">SEO Title</label>
        <input type="text" id="seo_title" name="seo_title" class="form-control" value="{{ old('seo_title', $page?->seo_title) }}">
        @error('seo_title') <div class="form-error">{{ $message }}</div> @enderror
    </div>
    <div class="form-group">
        <label for="seo_description">SEO Description</label>
        <input type="text" id="seo_description" name="seo_description" class="form-control" value="{{ old('seo_description', $page?->seo_description) }}">
        @error('seo_description') <div class="form-error">{{ $message }}</div> @enderror
    </div>
</div>

<label class="checkbox-row">
    <input type="checkbox" name="is_active" value="1" @checked(old('is_active', $page?->is_active ?? true))>
    Tampilkan di website
</label>
