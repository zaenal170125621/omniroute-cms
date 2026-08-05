@extends('layouts.admin')

@section('title', 'Tambah Layanan')

@section('content')

<div class="panel">
    <div class="panel-header">
        <h3>Tambah Layanan</h3>
        <a href="{{ route('admin.services.index') }}" class="topbar-btn">← Kembali</a>
    </div>
    <div class="panel-body">
        <form method="POST" action="{{ route('admin.services.store') }}">
            @csrf
            @include('admin.services._form')
            <div class="form-actions">
                <button type="submit" class="btn">Simpan Layanan</button>
                <a href="{{ route('admin.services.index') }}" class="btn btn-outline">Batal</a>
            </div>
        </form>
    </div>
</div>

@endsection
