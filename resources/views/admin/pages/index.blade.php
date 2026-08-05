@extends('layouts.admin')

@section('title', 'Halaman')

@section('content')

<div class="panel">
    <div class="panel-header">
        <h3>Daftar Halaman ({{ $pages->count() }})</h3>
        <a href="{{ route('admin.pages.create') }}" class="btn btn-sm">+ Tambah</a>
    </div>
    <div class="panel-body" style="padding:0;">
        @if ($pages->isEmpty())
            <div class="empty"><div class="empty-icon">▤</div><p>Belum ada halaman. Klik "+ Tambah" untuk membuat.</p></div>
        @else
            <div class="table-wrap">
                <table class="data">
                    <thead>
                        <tr>
                            <th>Halaman</th>
                            <th>URL</th>
                            <th>Status</th>
                            <th style="text-align:right;">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($pages as $page)
                            <tr>
                                <td><a href="{{ route('admin.pages.edit', $page) }}" class="row-title">{{ $page->title }}</a></td>
                                <td><span class="row-sub">/{{ $page->slug }}</span></td>
                                <td>
                                    <span class="badge {{ $page->is_active ? 'badge-green' : 'badge-gray' }}">
                                        {{ $page->is_active ? 'Aktif' : 'Nonaktif' }}
                                    </span>
                                </td>
                                <td style="text-align:right;white-space:nowrap;">
                                    <a href="{{ route('pages.show', $page->slug) }}" target="_blank" class="btn btn-outline btn-xs">Lihat</a>
                                    <a href="{{ route('admin.pages.edit', $page) }}" class="btn btn-outline btn-xs">Edit</a>
                                    <form method="POST" action="{{ route('admin.pages.destroy', $page) }}" style="display:inline;" data-confirm="Hapus halaman &quot;{{ $page->title }}&quot;?">
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
