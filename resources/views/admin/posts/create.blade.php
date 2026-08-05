@extends('layouts.admin')

@section('title', 'Tambah Artikel')

@section('content')

<div class="panel">
    <div class="panel-header">
        <h3>Tambah Artikel</h3>
        <a href="{{ route('admin.posts.index') }}" class="topbar-btn">← Kembali</a>
    </div>
    <div class="panel-body">
        <form method="POST" action="{{ route('admin.posts.store') }}" enctype="multipart/form-data">
            @csrf
            @include('admin.posts._form')
            <div class="form-actions">
                <button type="submit" class="btn">Simpan Artikel</button>
                <a href="{{ route('admin.posts.index') }}" class="btn btn-outline">Batal</a>
            </div>
        </form>
    </div>
</div>

@endsection
