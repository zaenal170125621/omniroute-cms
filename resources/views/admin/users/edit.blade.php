@extends('layouts.admin')

@section('title', 'Edit Pengguna')

@section('content')

<div class="panel">
    <div class="panel-header">
        <h3>Edit — {{ $user->name }}</h3>
        <a href="{{ route('admin.users.index') }}" class="topbar-btn">← Kembali</a>
    </div>
    <div class="panel-body">
        <form method="POST" action="{{ route('admin.users.update', $user) }}">
            @csrf
            @method('PUT')
            @include('admin.users._form', ['user' => $user])
            <div class="form-actions">
                <button type="submit" class="btn">Simpan Perubahan</button>
                <a href="{{ route('admin.users.index') }}" class="btn btn-outline">Batal</a>
            </div>
        </form>
    </div>
</div>

@endsection
