@extends('layouts.admin')

@section('title', 'Blog')

@section('content')

<div class="panel">
    <div class="panel-header">
        <h3>Daftar Artikel ({{ $posts->count() }})</h3>
        <a href="{{ route('admin.posts.create') }}" class="btn btn-sm">+ Tambah</a>
    </div>
    <div class="panel-body" style="padding:0;">
        @if ($posts->isEmpty())
            <div class="empty"><div class="empty-icon">☰</div><p>Belum ada artikel. Klik "+ Tambah" untuk membuat.</p></div>
        @else
            <div class="table-wrap">
                <table class="data">
                    <thead>
                        <tr>
                            <th>Artikel</th>
                            <th>Kategori</th>
                            <th>Status</th>
                            <th>Terbit</th>
                            <th style="text-align:right;">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($posts as $post)
                            <tr>
                                <td>
                                    <div class="cell-title">
                                        @if ($post->cover_image)
                                            <img src="{{ cover_url($post->cover_image) }}" alt="" class="row-thumb" loading="lazy">
                                        @endif
                                        <div>
                                            <a href="{{ route('admin.posts.edit', $post) }}" class="row-title">{{ $post->title }}</a>
                                            <div class="row-sub">/blog/{{ $post->slug }}</div>
                                        </div>
                                    </div>
                                </td>
                                <td>{{ $post->category ?: '—' }}</td>
                                <td>
                                    <span class="badge {{ $post->status === 'published' ? 'badge-green' : 'badge-amber' }}">
                                        {{ $post->status === 'published' ? 'Terbit' : 'Draft' }}
                                    </span>
                                </td>
                                <td>{{ $post->published_at?->format('d M Y') ?: '—' }}</td>
                                <td style="text-align:right;white-space:nowrap;">
                                    <a href="{{ route('blog.show', $post->slug) }}" target="_blank" class="btn btn-outline btn-xs">Lihat</a>
                                    <a href="{{ route('admin.posts.edit', $post) }}" class="btn btn-outline btn-xs">Edit</a>
                                    <form method="POST" action="{{ route('admin.posts.destroy', $post) }}" style="display:inline;" data-confirm="Hapus artikel &quot;{{ $post->title }}&quot;?">
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
