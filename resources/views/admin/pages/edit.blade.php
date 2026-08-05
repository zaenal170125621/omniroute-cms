@extends('layouts.admin')

@section('title', 'Edit Halaman')

@section('content')

<div class="panel">
    <div class="panel-header">
        <h3>Edit — {{ $page->title }}</h3>
        <a href="{{ route('admin.pages.index') }}" class="topbar-btn">← Kembali</a>
    </div>
    <div class="panel-body">
        <form method="POST" action="{{ route('admin.pages.update', $page) }}">
            @csrf
            @method('PUT')
            @include('admin.pages._form', ['page' => $page])
            <div class="form-actions">
                <button type="submit" class="btn">Simpan Perubahan</button>
                <a href="{{ route('admin.pages.index') }}" class="btn btn-outline">Batal</a>
            </div>
        </form>
    </div>
</div>

@endsection
