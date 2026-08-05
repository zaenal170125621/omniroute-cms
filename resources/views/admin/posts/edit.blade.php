@extends('layouts.admin')

@section('title', 'Edit Artikel')

@section('content')

<div class="panel">
    <div class="panel-header">
        <h3>Edit — {{ $post->title }}</h3>
        <a href="{{ route('admin.posts.index') }}" class="topbar-btn">← Kembali</a>
    </div>
    <div class="panel-body">
        <form method="POST" action="{{ route('admin.posts.update', $post) }}" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            @include('admin.posts._form', ['post' => $post])
            <div class="form-actions">
                <button type="submit" class="btn">Simpan Perubahan</button>
                <a href="{{ route('admin.posts.index') }}" class="btn btn-outline">Batal</a>
            </div>
        </form>
    </div>
</div>

@endsection
