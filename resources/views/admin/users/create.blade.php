@extends('layouts.admin')

@section('title', 'Tambah Pengguna')

@section('content')

<div class="panel">
    <div class="panel-header">
        <h3>Tambah Pengguna</h3>
        <a href="{{ route('admin.users.index') }}" class="topbar-btn">← Kembali</a>
    </div>
    <div class="panel-body">
        <form method="POST" action="{{ route('admin.users.store') }}">
            @csrf
            @include('admin.users._form')
            <div class="form-actions">
                <button type="submit" class="btn">Simpan Pengguna</button>
                <a href="{{ route('admin.users.index') }}" class="btn btn-outline">Batal</a>
            </div>
        </form>
    </div>
</div>

@endsection
