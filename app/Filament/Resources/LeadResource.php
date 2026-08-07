<?php

namespace App\Filament\Resources;

use App\Filament\Resources\LeadResource\Pages;
use App\Http\Controllers\OrderController;
use App\Models\Lead;
use Filament\Forms;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;
use Illuminate\Database\Eloquent\Builder;

class LeadResource extends Resource
{
    protected static ?string $model = Lead::class;

    protected static ?string $navigationIcon = 'heroicon-o-lightning-bolt';

    protected static ?string $navigationGroup = 'Prospek & Marketing';

    protected static ?string $modelLabel = 'Prospek';

    protected static ?string $pluralModelLabel = 'Prospek';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name')->required()->maxLength(255),
                Forms\Components\TextInput::make('email')->email()->required()->maxLength(255),
                Forms\Components\TextInput::make('phone')->maxLength(255),
                Forms\Components\TextInput::make('company')->maxLength(255),
                Forms\Components\Select::make('service_id')
                    ->label('Layanan')
                    ->relationship('service', 'title'),
                Forms\Components\Select::make('package')
                    ->options(collect(OrderController::PACKAGES)->pluck('name', 'code'))
                    ->searchable(),
                Forms\Components\TextInput::make('budget')->maxLength(255),
                Forms\Components\TextInput::make('timeline')->maxLength(50),
                Forms\Components\Textarea::make('message')->rows(4),
                Forms\Components\Select::make('status')
                    ->options(collect(Lead::STATUSES)->mapWithKeys(fn ($s, $key) => [$key => $s['label']]))
                    ->required(),
                Forms\Components\Select::make('source')
                    ->options(['order' => 'Order', 'contact' => 'Contact'])
                    ->required(),
                Forms\Components\Textarea::make('internal_notes')
                    ->rows(3)
                    ->helperText('Catatan internal — tidak tampil di publik.'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')->searchable()->sortable(),
                Tables\Columns\TextColumn::make('email')->searchable(),
                Tables\Columns\TextColumn::make('service.title')->label('Layanan'),
                Tables\Columns\BadgeColumn::make('status')->colors([
                    'primary' => 'baru',
                    'warning' => 'dihubungi',
                    'secondary' => 'proposal',
                    'success' => 'deal',
                    'danger' => 'batal',
                ]),
                Tables\Columns\TextColumn::make('source')->label('Sumber'),
                Tables\Columns\TextColumn::make('created_at')->dateTime('d M Y H:i')->sortable(),
            ])
            ->defaultSort('created_at', 'desc')
            ->filters([
                Tables\Filters\SelectFilter::make('status')
                    ->options(collect(Lead::STATUSES)->mapWithKeys(fn ($s, $key) => [$key => $s['label']])),
                Tables\Filters\SelectFilter::make('source')->options(['order' => 'Order', 'contact' => 'Contact']),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListLeads::route('/'),
            'create' => Pages\CreateLead::route('/create'),
            'edit' => Pages\EditLead::route('/{record}/edit'),
        ];
    }
}
