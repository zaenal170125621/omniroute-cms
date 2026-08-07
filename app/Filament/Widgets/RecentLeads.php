<?php

namespace App\Filament\Widgets;

use App\Models\Lead;
use Filament\Tables;
use Filament\Widgets\TableWidget;
use Illuminate\Database\Eloquent\Builder;

class RecentLeads extends TableWidget
{
    protected function getTableQuery(): Builder
    {
        return Lead::query()->with('service')->latest();
    }

    protected function getTableColumns(): array
    {
        return [
            Tables\Columns\TextColumn::make('name')->searchable(),
            Tables\Columns\TextColumn::make('email')->searchable(),
            Tables\Columns\TextColumn::make('service.title')->label('Layanan'),
            Tables\Columns\BadgeColumn::make('status')->colors([
                'primary' => 'baru',
                'warning' => 'dihubungi',
                'secondary' => 'proposal',
                'success' => 'deal',
                'danger' => 'batal',
            ]),
            Tables\Columns\TextColumn::make('created_at')->dateTime('d M Y H:i'),
        ];
    }

    protected function getDefaultTableSortColumn(): ?string
    {
        return 'created_at';
    }

    protected function getDefaultTableSortDirection(): string
    {
        return 'desc';
    }
}
