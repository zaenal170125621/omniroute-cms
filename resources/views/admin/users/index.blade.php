@extends('layouts.admin')

@section('title', 'Pengguna')

@section('content')

<div class="panel">
    <div class="panel-header">
        <h3>Daftar Pengguna ({{ $users->count() }})</h3>
        <a href="{{ route('admin.users.create') }}" class="btn btn-sm">+ Tambah</a>
    </div>
    <div class="panel-body" style="padding:0;">
        <div class="table-wrap">
            <table class="data">
                <thead>
                    <tr>
                        <th>Nama</th>
                        <th>Email</th>
                        <th>Role</th>
                        <th>Status</th>
                        <th style="text-align:right;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($users as $user)
                        <tr>
                            <td>
                                <span class="row-title">{{ $user->name }}</span>
                                @if ($user->id === auth()->id())
                                    <span class="badge badge-blue" style="margin-left:6px;">Anda</span>
                                @endif
                            </td>
                            <td>{{ $user->email }}</td>
                            <td>
                                <span class="badge {{ $user->role === 'admin' ? 'badge-purple' : ($user->role === 'editor' ? 'badge-blue' : 'badge-amber') }}">
                                    {{ ucfirst($user->role) }}
                                </span>
                            </td>
                            <td>
                                <span class="badge {{ $user->active ? 'badge-green' : 'badge-gray' }}">
                                    {{ $user->active ? 'Aktif' : 'Nonaktif' }}
                                </span>
                            </td>
                            <td style="text-align:right;white-space:nowrap;">
                                <a href="{{ route('admin.users.edit', $user) }}" class="btn btn-outline btn-xs">Edit</a>
                                @if ($user->id !== auth()->id())
                                    <form method="POST" action="{{ route('admin.users.destroy', $user) }}" style="display:inline;" data-confirm="Hapus user &quot;{{ $user->name }}&quot;?">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-xs">Hapus</button>
                                    </form>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

@endsection
