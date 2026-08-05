@extends('layouts.admin')

@section('title', 'Leads / Pesanan')

@section('content')

<div class="panel">
    <div class="panel-header">
        <h3>Daftar Lead ({{ $leads->total() }})</h3>
        <a href="{{ route('admin.leads.export', request()->query()) }}" class="btn btn-outline btn-sm">⭳ Ekspor CSV</a>
    </div>
    <div class="panel-body">
        <form method="GET" action="{{ route('admin.leads.index') }}" class="filters">
            <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari nama, email, perusahaan...">
            <select name="status">
                <option value="all">Semua Status</option>
                @foreach ($statuses as $key => $meta)
                    <option value="{{ $key }}" @selected(request('status') === $key)>{{ $meta['label'] }}</option>
                @endforeach
            </select>
            <select name="source">
                <option value="all">Semua Sumber</option>
                <option value="order" @selected(request('source') === 'order')>Order</option>
                <option value="contact" @selected(request('source') === 'contact')>Kontak</option>
            </select>
            <button type="submit" class="btn btn-sm">Filter</button>
            <a href="{{ route('admin.leads.index') }}" class="btn btn-outline btn-sm">Reset</a>
        </form>

        @if ($leads->isEmpty())
            <div class="empty"><div class="empty-icon">✉</div><p>Tidak ada lead yang cocok dengan filter.</p></div>
        @else
            <div class="table-wrap">
                <table class="data">
                    <thead>
                        <tr>
                            <th>Nama</th>
                            <th>Layanan / Paket</th>
                            <th>Sumber</th>
                            <th>Status</th>
                            <th>Waktu</th>
                            <th style="text-align:right;">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($leads as $lead)
                            <tr>
                                <td>
                                    <a href="{{ route('admin.leads.show', $lead) }}" class="row-title">{{ $lead->name }}</a>
                                    <div class="row-sub">{{ $lead->email }}{{ $lead->phone ? ' • ' . $lead->phone : '' }}</div>
                                </td>
                                <td>{{ $lead->service?->title ?: $lead->package ?: '—' }}</td>
                                <td>
                                    <span class="badge {{ $lead->source === 'order' ? 'badge-blue' : 'badge-purple' }}">
                                        {{ $lead->source === 'order' ? 'Order' : 'Kontak' }}
                                    </span>
                                </td>
                                <td>
                                    <form class="status-inline-form" method="POST" action="{{ route('admin.leads.status', $lead) }}" data-lead-id="{{ $lead->id }}">
                                        @csrf
                                        @method('PATCH')
                                        <select class="status-inline" name="status" data-original="{{ $lead->status }}">
                                            @foreach ($statuses as $key => $meta)
                                                <option value="{{ $key }}" @selected($key === $lead->status) style="color: {{ $meta['color'] }};">{{ $meta['label'] }}</option>
                                            @endforeach
                                        </select>
                                    </form>
                                </td>
                                <td>{{ $lead->createdLabel() }}</td>
                                <td style="text-align:right;white-space:nowrap;">
                                    <a href="{{ route('admin.leads.show', $lead) }}" class="btn btn-outline btn-xs">Detail</a>
                                    <form method="POST" action="{{ route('admin.leads.destroy', $lead) }}" style="display:inline;" data-confirm="Hapus lead &quot;{{ $lead->name }}&quot;?">
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

@if ($leads->hasPages())
    <div style="display:flex;justify-content:center;">{{ $leads->links() }}</div>
@endif

@endsection
