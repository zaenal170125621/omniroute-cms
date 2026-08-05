@extends('layouts.admin')

@section('title', 'Dashboard')

@section('content')

<div class="kpi-grid">
    <div class="kpi">
        <div class="num">{{ $stats['total_leads'] }}</div>
        <div class="label">Total Leads</div>
    </div>
    <div class="kpi">
        <div class="num">{{ $stats['new_leads_today'] }}</div>
        <div class="label">Lead Baru Hari Ini</div>
    </div>
    <div class="kpi">
        <div class="num">{{ $stats['deals'] }}</div>
        <div class="label">Deal</div>
    </div>
    <div class="kpi">
        <div class="num">{{ $stats['draft_posts'] }}</div>
        <div class="label">Artikel Draft</div>
    </div>
    <div class="kpi">
        <div class="num">{{ $stats['active_portfolios'] }}<small> / {{ $stats['total_portfolios'] }}</small></div>
        <div class="label">Portofolio Aktif</div>
    </div>
    <div class="kpi">
        <div class="num">{{ $stats['active_services'] }}</div>
        <div class="label">Layanan Aktif</div>
    </div>
</div>

<div class="chart-grid">
    <div class="panel">
        <div class="panel-header">
            <h3>Lead per Bulan — 12 Bulan Terakhir</h3>
            <a href="{{ route('admin.leads.index') }}" class="topbar-btn">Semua →</a>
        </div>
        <div class="panel-body">
            @php
                $monthTotals = array_map(fn ($m) => $leadsByMonth[$m] ?? 0, $months);
                $maxMonth = max(1, max($monthTotals));
                $monthNames = ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agu', 'Sep', 'Okt', 'Nov', 'Des'];
            @endphp
            @if (array_sum($monthTotals) === 0)
                <div class="empty"><p>Belum ada lead. Data akan muncul di sini.</p></div>
            @else
                <div class="chart-bars">
                    @foreach ($months as $i => $m)
                        @php
                            $total = $monthTotals[$i];
                            $height = $total > 0 ? max(5, round($total / $maxMonth * 100)) : 2;
                            $label = $monthNames[(int) substr($m, 5, 2) - 1];
                        @endphp
                        <div class="chart-col" title="{{ $label }} {{ substr($m, 0, 4) }}: {{ $total }} lead">
                            <div class="chart-bar" style="height:{{ $height }}%">
                                @if ($total > 0)<span class="chart-val">{{ $total }}</span>@endif
                            </div>
                            <span class="chart-label">{{ $label }}</span>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>
    </div>

    <div>
        <div class="panel">
            <div class="panel-header"><h3>Konversi</h3></div>
            <div class="panel-body">
                <div class="conv-num">{{ $conversionRate }}<small>%</small></div>
                <div class="conv-sub">{{ $stats['deals'] }} deal dari {{ $stats['total_leads'] }} lead</div>
            </div>
        </div>

        <div class="panel">
            <div class="panel-header"><h3>Lead per Layanan</h3></div>
            <div class="panel-body">
                @if ($leadsByService->isEmpty())
                    <div class="empty"><p>Belum ada data.</p></div>
                @else
                    @php $maxService = max(1, $leadsByService->max('total')); @endphp
                    @foreach ($leadsByService as $row)
                        <div class="bar-row">
                            <div class="bar-meta">
                                <span>{{ $row->service_name }}</span>
                                <strong>{{ $row->total }}</strong>
                            </div>
                            <div class="bar-track"><div class="bar-fill" style="width:{{ round($row->total / $maxService * 100) }}%"></div></div>
                        </div>
                    @endforeach
                @endif
            </div>
        </div>
    </div>
</div>

<div style="display:grid;grid-template-columns:1.6fr 1fr;gap:16px;align-items:start;">
    <div class="panel">
        <div class="panel-header">
            <h3>Lead Terbaru</h3>
            <a href="{{ route('admin.leads.index') }}" class="topbar-btn">Semua →</a>
        </div>
        <div class="panel-body" style="padding:0;">
            @if ($recentLeads->isEmpty())
                <div class="empty"><p>Belum ada lead.</p></div>
            @else
                <div class="table-wrap">
                    <table class="data">
                        <thead>
                            <tr>
                                <th>Nama</th>
                                <th>Layanan</th>
                                <th>Status</th>
                                <th>Waktu</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($recentLeads as $lead)
                                <tr>
                                    <td>
                                        <a href="{{ route('admin.leads.show', $lead) }}" class="row-title" style="text-decoration:underline;">{{ $lead->name }}</a>
                                        <div class="row-sub">{{ $lead->email }}</div>
                                    </td>
                                    <td>{{ $lead->service?->title ?: $lead->package ?: '—' }}</td>
                                    <td><span class="badge" style="background:{{ $lead->statusColor() }}1a;color:{{ $lead->statusColor() }};">{{ $lead->statusLabel() }}</span></td>
                                    <td>{{ $lead->createdLabel() }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
        </div>
    </div>

    <div>
        <div class="panel">
            <div class="panel-header">
                <h3>Artikel Draft</h3>
                <a href="{{ route('admin.posts.index') }}" class="topbar-btn">Kelola →</a>
            </div>
            <div class="panel-body" style="padding:0;">
                @if ($pendingPosts->isEmpty())
                    <div class="empty"><p>Semua artikel sudah terbit.</p></div>
                @else
                    <table class="data">
                        <tbody>
                            @foreach ($pendingPosts as $post)
                                <tr>
                                    <td>
                                        <a href="{{ route('admin.posts.edit', $post) }}" class="row-title">{{ $post->title }}</a>
                                        <div class="row-sub">{{ $post->created_at->diffForHumans() }}</div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                @endif
            </div>
        </div>

        @if ($leadsByStatus->isNotEmpty())
        <div class="panel">
            <div class="panel-header"><h3>Lead per Status</h3></div>
            <div class="panel-body">
                @foreach ($leadsByStatus as $status => $total)
                    <div style="display:flex;justify-content:space-between;align-items:center;padding:6px 0;border-bottom:1px solid var(--border);font-size:12.5px;">
                        <span class="badge" style="background:{{ \App\Models\Lead::STATUSES[$status]['color'] }}1a;color:{{ \App\Models\Lead::STATUSES[$status]['color'] }};">
                            {{ \App\Models\Lead::STATUSES[$status]['label'] }}
                        </span>
                        <strong>{{ $total }}</strong>
                    </div>
                @endforeach
            </div>
        </div>
        @endif
    </div>
</div>

@endsection
