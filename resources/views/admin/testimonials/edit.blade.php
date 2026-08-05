@extends('layouts.admin')

@section('title', 'Edit Testimoni')

@section('content')

<div class="panel">
    <div class="panel-header">
        <h3>Edit — {{ $testimonial->client_name }}</h3>
        <a href="{{ route('admin.testimonials.index') }}" class="topbar-btn">← Kembali</a>
    </div>
    <div class="panel-body">
        <form method="POST" action="{{ route('admin.testimonials.update', $testimonial) }}">
            @csrf
            @method('PUT')
            @include('admin.testimonials._form', ['testimonial' => $testimonial])
            <div class="form-actions">
                <button type="submit" class="btn">Simpan Perubahan</button>
                <a href="{{ route('admin.testimonials.index') }}" class="btn btn-outline">Batal</a>
            </div>
        </form>
    </div>
</div>

@endsection
