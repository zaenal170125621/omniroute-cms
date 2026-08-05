@extends('layouts.admin')

@section('title', 'Portofolio')

@section('content')

<div class="panel">
    <div class="panel-header">
        <h3>Daftar Portofolio ({{ $portfolios->count() }})</h3>
        <a href="{{ route('admin.portfolios.create') }}" class="btn btn-sm">+ Tambah</a>
    </div>
    <div class="panel-body" style="padding:0;">
        @if ($portfolios->isEmpty())
            <div class="empty"><div class="empty-icon">▣</div><p>Belum ada portofolio. Klik "+ Tambah" untuk membuat.</p></div>
        @else
            <div class="table-wrap">
                <table class="data">
                    <thead>
                        <tr>
                            <th>Proyek</th>
                            <th>Kategori</th>
                            <th>Tahun</th>
                            <th>Status</th>
                            <th style="text-align:right;">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($portfolios as $portfolio)
                            <tr>
                                <td>
                                    <div class="cell-title">
                                        @if ($portfolio->cover_image)
                                            <img src="{{ cover_url($portfolio->cover_image) }}" alt="" class="row-thumb" loading="lazy">
                                        @endif
                                        <div>
                                            <a href="{{ route('admin.portfolios.edit', $portfolio) }}" class="row-title">{{ $portfolio->title }}</a>
                                            <div class="row-sub">/{{ $portfolio->slug }}</div>
                                        </div>
                                    </div>
                                </td>
                                <td>{{ $portfolio->categoryLabel() }}</td>
                                <td>{{ $portfolio->year ?: '—' }}</td>
                                <td>
                                    <span class="badge {{ $portfolio->is_active ? 'badge-green' : 'badge-gray' }}">
                                        {{ $portfolio->is_active ? 'Aktif' : 'Nonaktif' }}
                                    </span>
                                </td>
                                <td style="text-align:right;white-space:nowrap;">
                                    <a href="{{ route('admin.portfolios.edit', $portfolio) }}" class="btn btn-outline btn-xs">Edit</a>
                                    <form method="POST" action="{{ route('admin.portfolios.destroy', $portfolio) }}" style="display:inline;" data-confirm="Hapus portofolio &quot;{{ $portfolio->title }}&quot;?">
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
