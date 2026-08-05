@extends('layouts.admin')

@section('title', 'Tambah Halaman')

@section('content')

<div class="panel">
    <div class="panel-header">
        <h3>Tambah Halaman</h3>
        <a href="{{ route('admin.pages.index') }}" class="topbar-btn">← Kembali</a>
    </div>
    <div class="panel-body">
        <form method="POST" action="{{ route('admin.pages.store') }}">
            @csrf
            @include('admin.pages._form')
            <div class="form-actions">
                <button type="submit" class="btn">Simpan Halaman</button>
                <a href="{{ route('admin.pages.index') }}" class="btn btn-outline">Batal</a>
            </div>
        </form>
    </div>
</div>

@endsection
