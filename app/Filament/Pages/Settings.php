<?php

namespace App\Filament\Pages;

use App\Models\Setting;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Pages\Page;

class Settings extends Page implements HasForms
{
    use InteractsWithForms;

    protected static ?string $navigationIcon = 'heroicon-o-cog';

    protected static ?string $title = 'Pengaturan';

    protected static ?int $navigationSort = 99;

    protected static string $view = 'filament.pages.settings';

    public function mount(): void
    {
        $keys = [
            'company_name', 'tagline', 'logo_text', 'email', 'phone', 'address',
            'whatsapp', 'instagram', 'linkedin', 'footer_text',
            'hero_badge', 'hero_title', 'hero_subtitle', 'hero_cta_primary', 'hero_cta_secondary',
            'seo_title', 'seo_description', 'order_note', 'lead_notify_email', 'analytics_head',
        ];

        $this->form->fill(collect($keys)->mapWithKeys(
            fn (string $key) => [$key => Setting::get($key)]
        )->all());
    }

    public function save(): void
    {
        foreach ($this->form->getState() as $key => $value) {
            Setting::set($key, $value);
        }

        \Filament\Facades\Filament::notify('success', 'Pengaturan berhasil disimpan.');
    }

    protected function getFormSchema(): array
    {
        return [
            Section::make('Identitas Perusahaan')
                ->schema([
                    Grid::make(2)->schema([
                        TextInput::make('company_name')->label('Nama Perusahaan')->required(),
                        TextInput::make('tagline')->label('Tagline'),
                        TextInput::make('logo_text')->label('Teks Logo'),
                        TextInput::make('email')->label('Email')->email(),
                        TextInput::make('phone')->label('Telepon'),
                        TextInput::make('address')->label('Alamat'),
                    ]),
                ]),
            Section::make('Kontak & Sosial Media')
                ->schema([
                    Grid::make(3)->schema([
                        TextInput::make('whatsapp')->label('WhatsApp (format 62...)')->helperText('Tanpa tanda + atau spasi.'),
                        TextInput::make('instagram')->label('Instagram URL'),
                        TextInput::make('linkedin')->label('LinkedIn URL'),
                    ]),
                ]),
            Section::make('Hero Beranda')
                ->schema([
                    Grid::make(2)->schema([
                        TextInput::make('hero_badge')->label('Badge'),
                        TextInput::make('hero_cta_primary')->label('Tombol Utama'),
                        TextInput::make('hero_cta_secondary')->label('Tombol Sekunder'),
                    ]),
                    Textarea::make('hero_title')->label('Judul')->rows(2),
                    Textarea::make('hero_subtitle')->label('Subjudul')->rows(3),
                ]),
            Section::make('SEO & Footer')
                ->schema([
                    Grid::make(2)->schema([
                        TextInput::make('seo_title')->label('SEO Title'),
                        Textarea::make('seo_description')->label('SEO Description')->rows(3),
                        Textarea::make('footer_text')->label('Teks Footer')->rows(2),
                        Textarea::make('order_note')->label('Catatan Form Order')->rows(3),
                    ]),
                ]),
            Section::make('Notifikasi & Analitik')
                ->schema([
                    Grid::make(2)->schema([
                        TextInput::make('lead_notify_email')->label('Email Notifikasi Lead Baru')->email(),
                        Textarea::make('analytics_head')->label('Kode Head (Analytics)')->rows(3)->helperText('Script tracking yang disisipkan di <head>.'),
                    ]),
                ]),
        ];
    }
}
