@extends('layouts.admin')

@section('title', 'Edit Portofolio')

@section('content')

<div class="panel">
    <div class="panel-header">
        <h3>Edit — {{ $portfolio->title }}</h3>
        <a href="{{ route('admin.portfolios.index') }}" class="topbar-btn">← Kembali</a>
    </div>
    <div class="panel-body">
        <form method="POST" action="{{ route('admin.portfolios.update', $portfolio) }}" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            @include('admin.portfolios._form', ['portfolio' => $portfolio])
            <div class="form-actions">
                <button type="submit" class="btn">Simpan Perubahan</button>
                <a href="{{ route('admin.portfolios.index') }}" class="btn btn-outline">Batal</a>
            </div>
        </form>
    </div>
</div>

@endsection
