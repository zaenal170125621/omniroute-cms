@php
    $testimonial = $testimonial ?? null;
@endphp

<div class="form-group">
    <label for="quote">Kutipan *</label>
    <textarea id="quote" name="quote" class="form-control" rows="4" required>{{ old('quote', $testimonial?->quote) }}</textarea>
    @error('quote') <div class="form-error">{{ $message }}</div> @enderror
</div>

<div class="form-grid">
    <div class="form-group">
        <label for="client_name">Nama Klien *</label>
        <input type="text" id="client_name" name="client_name" class="form-control" value="{{ old('client_name', $testimonial?->client_name) }}" required>
        @error('client_name') <div class="form-error">{{ $message }}</div> @enderror
    </div>
    <div class="form-group">
        <label for="position">Jabatan</label>
        <input type="text" id="position" name="position" class="form-control" value="{{ old('position', $testimonial?->position) }}">
        @error('position') <div class="form-error">{{ $message }}</div> @enderror
    </div>
</div>

<div class="form-grid">
    <div class="form-group">
        <label for="company">Perusahaan</label>
        <input type="text" id="company" name="company" class="form-control" value="{{ old('company', $testimonial?->company) }}">
        @error('company') <div class="form-error">{{ $message }}</div> @enderror
    </div>
    <div class="form-group">
        <label for="rating">Rating (1–5)</label>
        <select id="rating" name="rating" class="form-control">
            @for ($i = 5; $i >= 1; $i--)
                <option value="{{ $i }}" @selected(old('rating', $testimonial?->rating ?? 5) == $i)>{{ $i }} ★</option>
            @endfor
        </select>
        @error('rating') <div class="form-error">{{ $message }}</div> @enderror
    </div>
</div>

<div class="form-grid">
    <div class="form-group">
        <label for="photo">URL Foto</label>
        <input type="text" id="photo" name="photo" class="form-control" value="{{ old('photo', $testimonial?->photo) }}" placeholder="https://... (opsional)">
        @error('photo') <div class="form-error">{{ $message }}</div> @enderror
    </div>
    <div class="form-group">
        <label for="sort_order">Urutan Tampil</label>
        <input type="number" id="sort_order" name="sort_order" class="form-control" value="{{ old('sort_order', $testimonial?->sort_order ?? 0) }}" min="0">
        @error('sort_order') <div class="form-error">{{ $message }}</div> @enderror
    </div>
</div>

<label class="checkbox-row">
    <input type="checkbox" name="is_active" value="1" @checked(old('is_active', $testimonial?->is_active ?? true))>
    Tampilkan di website
</label>
