@extends('layouts.admin')

@section('title', 'Edit Layanan')

@section('content')

<div class="panel">
    <div class="panel-header">
        <h3>Edit — {{ $service->title }}</h3>
        <a href="{{ route('admin.services.index') }}" class="topbar-btn">← Kembali</a>
    </div>
    <div class="panel-body">
        <form method="POST" action="{{ route('admin.services.update', $service) }}">
            @csrf
            @method('PUT')
            @include('admin.services._form', ['service' => $service])
            <div class="form-actions">
                <button type="submit" class="btn">Simpan Perubahan</button>
                <a href="{{ route('admin.services.index') }}" class="btn btn-outline">Batal</a>
            </div>
        </form>
    </div>
</div>

@endsection
