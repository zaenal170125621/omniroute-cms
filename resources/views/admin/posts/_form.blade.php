@php
    $post = $post ?? null;
@endphp

<div class="form-grid">
    <div class="form-group">
        <label for="title">Judul Artikel *</label>
        <input type="text" id="title" name="title" class="form-control" value="{{ old('title', $post?->title) }}" required>
        @error('title') <div class="form-error">{{ $message }}</div> @enderror
    </div>
    <div class="form-group">
        <label for="category">Kategori</label>
        <input type="text" id="category" name="category" class="form-control" value="{{ old('category', $post?->category) }}" placeholder="Tips Bisnis">
        @error('category') <div class="form-error">{{ $message }}</div> @enderror
    </div>
</div>

<div class="form-grid">
    <div class="form-group">
        <label for="slug">Slug</label>
        <input type="text" id="slug" name="slug" class="form-control" value="{{ old('slug', $post?->slug) }}" placeholder="otomatis dari judul">
        @error('slug') <div class="form-error">{{ $message }}</div> @enderror
    </div>
    <div class="form-group">
        <label for="status">Status *</label>
        <select id="status" name="status" class="form-control" required>
            <option value="draft" @selected(old('status', $post?->status ?? 'draft') === 'draft')>Draft</option>
            <option value="published" @selected(old('status', $post?->status) === 'published')>Terbit</option>
        </select>
        @error('status') <div class="form-error">{{ $message }}</div> @enderror
    </div>
</div>

<div class="form-group">
    <label for="excerpt">Ringkasan</label>
    <textarea id="excerpt" name="excerpt" class="form-control" rows="2">{{ old('excerpt', $post?->excerpt) }}</textarea>
    <div class="form-hint">Kosongkan untuk otomatis dari isi artikel.</div>
    @error('excerpt') <div class="form-error">{{ $message }}</div> @enderror
</div>

<div class="form-group">
    <label for="content">Isi Artikel *</label>
    <textarea id="content" name="content" class="form-control" rows="14" required>{{ old('content', $post?->content) }}</textarea>
    <div class="form-hint">Format sederhana: "# Judul" untuk heading, "- item" untuk list, "> teks" untuk kutipan.</div>
    @error('content') <div class="form-error">{{ $message }}</div> @enderror
</div>

<div class="form-grid">
    <div class="form-group">
        <label for="cover_image">Gambar Cover</label>
        <input type="file" id="cover_image" name="cover_image" class="form-control" accept="image/*">
        @if ($post?->cover_image)
            <div class="form-hint">Gambar saat ini: {{ $post->cover_image }}</div>
        @endif
        @error('cover_image') <div class="form-error">{{ $message }}</div> @enderror
    </div>
    <div class="form-group">
        <label for="published_at">Tanggal Terbit</label>
        <input type="datetime-local" id="published_at" name="published_at" class="form-control" value="{{ old('published_at', $post?->published_at?->format('Y-m-d\TH:i')) }}">
        <div class="form-hint">Kosongkan untuk otomatis = sekarang saat publish.</div>
        @error('published_at') <div class="form-error">{{ $message }}</div> @enderror
    </div>
</div>

<div class="form-grid">
    <div class="form-group">
        <label for="seo_title">SEO Title</label>
        <input type="text" id="seo_title" name="seo_title" class="form-control" value="{{ old('seo_title', $post?->seo_title) }}">
        @error('seo_title') <div class="form-error">{{ $message }}</div> @enderror
    </div>
    <div class="form-group">
        <label for="seo_description">SEO Description</label>
        <input type="text" id="seo_description" name="seo_description" class="form-control" value="{{ old('seo_description', $post?->seo_description) }}">
        @error('seo_description') <div class="form-error">{{ $message }}</div> @enderror
    </div>
</div>
