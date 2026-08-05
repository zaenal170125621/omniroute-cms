@extends('layouts.admin')

@section('title', 'Testimoni')

@section('content')

<div class="panel">
    <div class="panel-header">
        <h3>Daftar Testimoni ({{ $testimonials->count() }})</h3>
        <a href="{{ route('admin.testimonials.create') }}" class="btn btn-sm">+ Tambah</a>
    </div>
    <div class="panel-body" style="padding:0;">
        @if ($testimonials->isEmpty())
            <div class="empty"><div class="empty-icon">❝</div><p>Belum ada testimoni. Klik "+ Tambah" untuk membuat.</p></div>
        @else
            <div class="table-wrap">
                <table class="data">
                    <thead>
                        <tr>
                            <th>Klien</th>
                            <th>Perusahaan</th>
                            <th>Rating</th>
                            <th>Status</th>
                            <th style="text-align:right;">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($testimonials as $testimonial)
                            <tr>
                                <td>
                                    <a href="{{ route('admin.testimonials.edit', $testimonial) }}" class="row-title">{{ $testimonial->client_name }}</a>
                                    <div class="row-sub">{{ Str::limit($testimonial->quote, 60) }}</div>
                                </td>
                                <td>{{ $testimonial->company ?: '—' }}</td>
                                <td>{{ str_repeat('★', $testimonial->rating) }}</td>
                                <td>
                                    <span class="badge {{ $testimonial->is_active ? 'badge-green' : 'badge-gray' }}">
                                        {{ $testimonial->is_active ? 'Aktif' : 'Nonaktif' }}
                                    </span>
                                </td>
                                <td style="text-align:right;white-space:nowrap;">
                                    <a href="{{ route('admin.testimonials.edit', $testimonial) }}" class="btn btn-outline btn-xs">Edit</a>
                                    <form method="POST" action="{{ route('admin.testimonials.destroy', $testimonial) }}" style="display:inline;" data-confirm="Hapus testimoni &quot;{{ $testimonial->client_name }}&quot;?">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-xs">Hapus</button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif
    </div>
</div>

@endsection
