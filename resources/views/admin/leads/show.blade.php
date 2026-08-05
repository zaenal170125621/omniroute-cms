@extends('layouts.admin')

@section('title', 'Detail Lead')

@section('content')

<div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:16px;">
    <a href="{{ route('admin.leads.index') }}" class="topbar-btn">← Semua Leads</a>
    <span class="badge" style="background:{{ $lead->statusColor() }}1a;color:{{ $lead->statusColor() }};font-size:12px;padding:4px 12px;">
        {{ $lead->statusLabel() }}
    </span>
</div>

<div class="lead-grid">

    <div>
        <div class="panel">
            <div class="panel-header">
                <h3>{{ $lead->name }}</h3>
                <span class="row-sub">{{ $lead->source === 'order' ? 'Via Form Order' : 'Via Form Kontak' }} • {{ $lead->createdLabel() }}</span>
            </div>
            <div class="panel-body">
                <div class="detail-list">
                    <div class="detail-item">
                        <div class="d-label">Email</div>
                        <div class="d-value">{{ $lead->email }}</div>
                    </div>
                    <div class="detail-item">
                        <div class="d-label">Telepon</div>
                        <div class="d-value">{{ $lead->phone ?: '—' }}</div>
                    </div>
                    <div class="detail-item">
                        <div class="d-label">Perusahaan</div>
                        <div class="d-value">{{ $lead->company ?: '—' }}</div>
                    </div>
                    <div class="detail-item">
                        <div class="d-label">Paket</div>
                        <div class="d-value">{{ ucfirst($lead->package ?: '—') }}</div>
                    </div>
                    <div class="detail-item">
                        <div class="d-label">Layanan</div>
                        <div class="d-value">{{ $lead->service?->title ?: '—' }}</div>
                    </div>
                    <div class="detail-item">
                        <div class="d-label">Budget</div>
                        <div class="d-value">{{ $lead->budget ?: '—' }}</div>
                    </div>
                    <div class="detail-item">
                        <div class="d-label">Target</div>
                        <div class="d-value">{{ $lead->timeline ?: '—' }}</div>
                    </div>
                    <div class="detail-item">
                        <div class="d-label">Status</div>
                        <div class="d-value">{{ $lead->statusLabel() }}</div>
                    </div>
                </div>

                @if ($lead->message)
                    <div style="margin-top:16px;padding-top:16px;border-top:1px solid var(--border);">
                        <div class="d-label" style="font-size:10.5px;font-weight:700;letter-spacing:0.08em;text-transform:uppercase;color:var(--muted);margin-bottom:8px;">Pesan Klien</div>
                        <p style="font-size:13px;line-height:1.7;white-space:pre-wrap;">{{ $lead->message }}</p>
                    </div>
                @endif

                @if ($lead->internal_notes)
                    <div style="margin-top:16px;padding-top:16px;border-top:1px solid var(--border);">
                        <div class="d-label" style="font-size:10.5px;font-weight:700;letter-spacing:0.08em;text-transform:uppercase;color:var(--muted);margin-bottom:8px;">Catatan Internal</div>
                        <p style="font-size:13px;line-height:1.7;white-space:pre-wrap;color:var(--muted);">{{ $lead->internal_notes }}</p>
                    </div>
                @endif
            </div>
        </div>

        <div class="panel">
            <div class="panel-header"><h3>Riwayat Status</h3></div>
            <div class="panel-body">
                @if ($lead->histories->isEmpty())
                    <p style="font-size:12.5px;color:var(--muted);">Belum ada riwayat.</p>
                @else
                    <div class="timeline">
                        @foreach ($lead->histories as $history)
                            <div class="timeline-item">
                                <div class="t-time">{{ $history->created_at->format('d M Y H:i') }} — oleh {{ $history->user?->name ?: 'Sistem' }}</div>
                                <div class="t-status">{{ \App\Models\Lead::STATUSES[$history->status]['label'] ?? $history->status }}</div>
                                @if ($history->note)
                                    <div class="t-note">{{ $history->note }}</div>
                                @endif
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>
        </div>
    </div>

    <div>
        <div class="panel">
            <div class="panel-header"><h3>Update Status</h3></div>
            <div class="panel-body">
                <form method="POST" action="{{ route('admin.leads.status', $lead) }}">
                    @csrf
                    @method('PATCH')
                    <div class="form-group">
                        <label for="status">Status</label>
                        <select id="status" name="status" class="form-control">
                            @foreach ($statuses as $key => $meta)
                                <option value="{{ $key }}" @selected($lead->status === $key)>{{ $meta['label'] }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="note">Catatan</label>
                        <textarea id="note" name="note" class="form-control" rows="3" placeholder="Hasil panggilan, catatan follow-up..."></textarea>
                    </div>
                    <button type="submit" class="btn btn-block">Simpan</button>
                </form>

                @if (setting('whatsapp'))
                    <a href="https://wa.me/{{ setting('whatsapp') }}" target="_blank" class="btn btn-outline btn-block" style="margin-top:10px;">WhatsApp ↗</a>
                @endif
            </div>
        </div>
    </div>

</div>

@endsection
