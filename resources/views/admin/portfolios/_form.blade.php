@php
    $portfolio = $portfolio ?? null;
@endphp

<div class="form-grid">
    <div class="form-group">
        <label for="title">Judul Proyek *</label>
        <input type="text" id="title" name="title" class="form-control" value="{{ old('title', $portfolio?->title) }}" required>
        @error('title') <div class="form-error">{{ $message }}</div> @enderror
    </div>
    <div class="form-group">
        <label for="category">Kategori *</label>
        <select id="category" name="category" class="form-control" required>
            @foreach ($categories as $key => $label)
                <option value="{{ $key }}" @selected(old('category', $portfolio?->category) === $key)>{{ $label }}</option>
            @endforeach
        </select>
        @error('category') <div class="form-error">{{ $message }}</div> @enderror
    </div>
</div>

<div class="form-grid">
    <div class="form-group">
        <label for="slug">Slug</label>
        <input type="text" id="slug" name="slug" class="form-control" value="{{ old('slug', $portfolio?->slug) }}" placeholder="otomatis dari judul">
        @error('slug') <div class="form-error">{{ $message }}</div> @enderror
    </div>
    <div class="form-group">
        <label for="year">Tahun</label>
        <input type="text" id="year" name="year" class="form-control" value="{{ old('year', $portfolio?->year) }}" placeholder="2026">
        @error('year') <div class="form-error">{{ $message }}</div> @enderror
    </div>
</div>

<div class="form-grid">
    <div class="form-group">
        <label for="cover_image">Gambar Cover</label>
        <input type="file" id="cover_image" name="cover_image" class="form-control" accept="image/*">
        @if ($portfolio?->cover_image)
            <div class="form-hint">Gambar saat ini: {{ $portfolio->cover_image }} (upload baru untuk mengganti)</div>
        @else
            <div class="form-hint">Kosongkan untuk memakai blok warna Swiss.</div>
        @endif
        @error('cover_image') <div class="form-error">{{ $message }}</div> @enderror
    </div>
    <div class="form-group">
        <label for="cover_color">Warna Blok</label>
        <input type="text" id="cover_color" name="cover_color" class="form-control" value="{{ old('cover_color', $portfolio?->cover_color ?? '#0A0A0A') }}" placeholder="#0A0A0A">
        <div class="form-hint">Dipakai jika gambar cover kosong.</div>
        @error('cover_color') <div class="form-error">{{ $message }}</div> @enderror
    </div>
</div>

<div class="form-group">
    <label for="description">Deskripsi Proyek *</label>
    <textarea id="description" name="description" class="form-control" rows="8" required>{{ old('description', $portfolio?->description) }}</textarea>
    @error('description') <div class="form-error">{{ $message }}</div> @enderror
</div>

<div class="form-grid">
    <div class="form-group">
        <label for="link">Link Live</label>
        <input type="url" id="link" name="link" class="form-control" value="{{ old('link', $portfolio?->link) }}" placeholder="https://...">
        @error('link') <div class="form-error">{{ $message }}</div> @enderror
    </div>
    <div class="form-group">
        <label for="sort_order">Urutan Tampil</label>
        <input type="number" id="sort_order" name="sort_order" class="form-control" value="{{ old('sort_order', $portfolio?->sort_order ?? 0) }}" min="0">
        @error('sort_order') <div class="form-error">{{ $message }}</div> @enderror
    </div>
</div>

<div class="form-group">
    <label>Teknologi (tags)</label>
    <div class="dyn-list" data-name="tech_stack" data-placeholder="Laravel, Vue, PostgreSQL...">
        @foreach (old('tech_stack', $portfolio?->tech_stack ?? []) as $tech)
            <div class="dyn-row">
                <input type="text" class="form-control" name="tech_stack[]" value="{{ $tech }}" placeholder="Teknologi">
                <button type="button" class="dyn-remove" title="Hapus">×</button>
            </div>
        @endforeach
        <button type="button" class="dyn-add">+ Tambah teknologi</button>
    </div>
</div>

<label class="checkbox-row">
    <input type="checkbox" name="is_active" value="1" @checked(old('is_active', $portfolio?->is_active ?? true))>
    Tampilkan di website
</label>
