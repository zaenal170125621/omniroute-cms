@extends('layouts.admin')

@section('title', 'Layanan')

@section('content')

<div class="panel">
    <div class="panel-header">
        <h3>Daftar Layanan ({{ $services->count() }})</h3>
        <a href="{{ route('admin.services.create') }}" class="btn btn-sm">+ Tambah</a>
    </div>
    <div class="panel-body" style="padding:0;">
        @if ($services->isEmpty())
            <div class="empty"><div class="empty-icon">◈</div><p>Belum ada layanan. Klik "+ Tambah" untuk membuat.</p></div>
        @else
            <div class="table-wrap">
                <table class="data">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Layanan</th>
                            <th>Harga</th>
                            <th>Status</th>
                            <th style="text-align:right;">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($services as $service)
                            <tr>
                                <td style="color:var(--muted);">{{ $service->sort_order }}</td>
                                <td>
                                    <a href="{{ route('admin.services.edit', $service) }}" class="row-title">{{ $service->title }}</a>
                                    <div class="row-sub">/{{ $service->slug }}</div>
                                </td>
                                <td>{{ $service->starting_price ?: '—' }}</td>
                                <td>
                                    <span class="badge {{ $service->is_active ? 'badge-green' : 'badge-gray' }}">
                                        {{ $service->is_active ? 'Aktif' : 'Nonaktif' }}
                                    </span>
                                </td>
                                <td style="text-align:right;white-space:nowrap;">
                                    <a href="{{ route('admin.services.edit', $service) }}" class="btn btn-outline btn-xs">Edit</a>
                                    <form method="POST" action="{{ route('admin.services.destroy', $service) }}" style="display:inline;" data-confirm="Hapus layanan &quot;{{ $service->title }}&quot;?">
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
