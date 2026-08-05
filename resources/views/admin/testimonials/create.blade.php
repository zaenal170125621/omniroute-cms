@extends('layouts.admin')

@section('title', 'Tambah Testimoni')

@section('content')

<div class="panel">
    <div class="panel-header">
        <h3>Tambah Testimoni</h3>
        <a href="{{ route('admin.testimonials.index') }}" class="topbar-btn">← Kembali</a>
    </div>
    <div class="panel-body">
        <form method="POST" action="{{ route('admin.testimonials.store') }}">
            @csrf
            @include('admin.testimonials._form')
            <div class="form-actions">
                <button type="submit" class="btn">Simpan Testimoni</button>
                <a href="{{ route('admin.testimonials.index') }}" class="btn btn-outline">Batal</a>
            </div>
        </form>
    </div>
</div>

@endsection
