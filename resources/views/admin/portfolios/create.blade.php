@extends('layouts.admin')

@section('title', 'Tambah Portofolio')

@section('content')

<div class="panel">
    <div class="panel-header">
        <h3>Tambah Portofolio</h3>
        <a href="{{ route('admin.portfolios.index') }}" class="topbar-btn">← Kembali</a>
    </div>
    <div class="panel-body">
        <form method="POST" action="{{ route('admin.portfolios.store') }}" enctype="multipart/form-data">
            @csrf
            @include('admin.portfolios._form')
            <div class="form-actions">
                <button type="submit" class="btn">Simpan Portofolio</button>
                <a href="{{ route('admin.portfolios.index') }}" class="btn btn-outline">Batal</a>
            </div>
        </form>
    </div>
</div>

@endsection
