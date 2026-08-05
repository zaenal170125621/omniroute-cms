@php
    $service = $service ?? null;
@endphp

<div class="form-group">
    <label for="title">Judul Layanan *</label>
    <input type="text" id="title" name="title" class="form-control" value="{{ old('title', $service?->title) }}" required>
    @error('title') <div class="form-error">{{ $message }}</div> @enderror
</div>

<div class="form-grid">
    <div class="form-group">
        <label for="slug">Slug</label>
        <input type="text" id="slug" name="slug" class="form-control" value="{{ old('slug', $service?->slug) }}" placeholder="otomatis dari judul">
        @error('slug') <div class="form-error">{{ $message }}</div> @enderror
    </div>
    <div class="form-group">
        <label for="icon">Ikon</label>
        <input type="text" id="icon" name="icon" class="form-control" value="{{ old('icon', $service?->icon) }}" placeholder="building, cart, code...">
        @error('icon') <div class="form-error">{{ $message }}</div> @enderror
    </div>
</div>

<div class="form-group">
    <label for="short_description">Deskripsi Singkat *</label>
    <textarea id="short_description" name="short_description" class="form-control" rows="2" required>{{ old('short_description', $service?->short_description) }}</textarea>
    @error('short_description') <div class="form-error">{{ $message }}</div> @enderror
</div>

<div class="form-group">
    <label for="description">Deskripsi Lengkap *</label>
    <textarea id="description" name="description" class="form-control" rows="8" required>{{ old('description', $service?->description) }}</textarea>
    <div class="form-hint">Baris kosong = paragraf baru. Bisa ditambah daftar dengan tanda "-" pada awal baris.</div>
    @error('description') <div class="form-error">{{ $message }}</div> @enderror
</div>

<div class="form-group">
    <label>Fitur (list)</label>
    <div class="dyn-list" data-name="features" data-placeholder="Fitur">
        @foreach (old('features', $service?->features ?? []) as $feature)
            <div class="dyn-row">
                <input type="text" class="form-control" name="features[]" value="{{ $feature }}" placeholder="Fitur">
                <button type="button" class="dyn-remove" title="Hapus">×</button>
            </div>
        @endforeach
        <button type="button" class="dyn-add">+ Tambah fitur</button>
    </div>
</div>

<div class="form-grid">
    <div class="form-group">
        <label for="starting_price">Harga Mulai</label>
        <input type="text" id="starting_price" name="starting_price" class="form-control" value="{{ old('starting_price', $service?->starting_price) }}" placeholder="Rp 7.500.000">
        @error('starting_price') <div class="form-error">{{ $message }}</div> @enderror
    </div>
    <div class="form-group">
        <label for="sort_order">Urutan Tampil</label>
        <input type="number" id="sort_order" name="sort_order" class="form-control" value="{{ old('sort_order', $service?->sort_order ?? 0) }}" min="0">
        @error('sort_order') <div class="form-error">{{ $message }}</div> @enderror
    </div>
</div>

<label class="checkbox-row">
    <input type="checkbox" name="is_active" value="1" @checked(old('is_active', $service?->is_active ?? true))>
    Tampilkan di website
</label>
