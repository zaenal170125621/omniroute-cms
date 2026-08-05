@php
    $user = $user ?? null;
@endphp

<div class="form-grid">
    <div class="form-group">
        <label for="name">Nama Lengkap *</label>
        <input type="text" id="name" name="name" class="form-control" value="{{ old('name', $user?->name) }}" required>
        @error('name') <div class="form-error">{{ $message }}</div> @enderror
    </div>
    <div class="form-group">
        <label for="email">Email *</label>
        <input type="email" id="email" name="email" class="form-control" value="{{ old('email', $user?->email) }}" required>
        @error('email') <div class="form-error">{{ $message }}</div> @enderror
    </div>
</div>

<div class="form-grid">
    <div class="form-group">
        <label for="password">{{ $user ? 'Password Baru' : 'Password *' }}</label>
        <input type="password" id="password" name="password" class="form-control" @required(!$user)>
        @if ($user)
            <div class="form-hint">Kosongkan jika tidak ingin mengubah.</div>
        @endif
        @error('password') <div class="form-error">{{ $message }}</div> @enderror
    </div>
    <div class="form-group">
        <label for="role">Role *</label>
        <select id="role" name="role" class="form-control" required>
            <option value="admin" @selected(old('role', $user?->role) === 'admin')>Admin — akses penuh</option>
            <option value="editor" @selected(old('role', $user?->role) === 'editor')>Editor — kelola konten</option>
            <option value="sales" @selected(old('role', $user?->role) === 'sales')>Sales — kelola leads</option>
        </select>
        @error('role') <div class="form-error">{{ $message }}</div> @enderror
    </div>
</div>

<label class="checkbox-row">
    <input type="checkbox" name="active" value="1" @checked(old('active', $user?->active ?? true))>
    Akun aktif
</label>
