<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PortfolioResource\Pages;
use App\Models\Portfolio;
use Filament\Forms;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;

class PortfolioResource extends Resource
{
    protected static ?string $model = Portfolio::class;

    protected static ?string $navigationIcon = 'heroicon-o-photograph';

    protected static ?string $navigationGroup = 'Konten';

    protected static ?string $modelLabel = 'Portofolio';

    protected static ?string $pluralModelLabel = 'Portofolio';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('title')->required()->maxLength(255),
                Forms\Components\TextInput::make('slug')
                    ->required()
                    ->maxLength(255)
                    ->helperText('Jangan gunakan "pricing" — itu route khusus, bukan halaman CMS.'),
                Forms\Components\Select::make('category')->options(Portfolio::CATEGORIES)->required(),
                Forms\Components\FileUpload::make('cover_image')->image()->directory('portfolios'),
                Forms\Components\ColorPicker::make('cover_color')->default('#0A0A0A'),
                Forms\Components\Textarea::make('description')->required()->rows(6),
                Forms\Components\TextInput::make('link')->url(),
                Forms\Components\TagsInput::make('tech_stack')->label('Tech stack (satu per tag)'),
                Forms\Components\TextInput::make('year')->maxLength(10),
                Forms\Components\TextInput::make('client_name')->label('Nama klien'),
                Forms\Components\TextInput::make('duration')->label('Durasi'),
                Forms\Components\Textarea::make('challenge')->label('Tantangan')->rows(3),
                Forms\Components\Textarea::make('solution')->label('Solusi')->rows(3),
                Forms\Components\Textarea::make('result')->label('Hasil')->rows(3),
                Forms\Components\TagsInput::make('metrics')->label('Metrik (satu per tag)'),
                Forms\Components\TextInput::make('sort_order')->numeric()->default(0),
                Forms\Components\Toggle::make('is_active')->default(true),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('title')->searchable()->sortable(),
                Tables\Columns\TextColumn::make('category')->sortable(),
                Tables\Columns\TextColumn::make('year'),
                Tables\Columns\BooleanColumn::make('is_active')->sortable(),
                Tables\Columns\TextColumn::make('sort_order')->sortable(),
            ])
            ->defaultSort('sort_order')
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
            'index' => Pages\ListPortfolios::route('/'),
            'create' => Pages\CreatePortfolio::route('/create'),
            'edit' => Pages\EditPortfolio::route('/{record}/edit'),
        ];
    }
}
