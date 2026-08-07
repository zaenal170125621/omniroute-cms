<?php

namespace App\Filament\Widgets;

use App\Models\Lead;
use App\Models\NewsletterSubscriber;
use App\Models\Post;
use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Card;

class StatsOverview extends StatsOverviewWidget
{
    protected function getCards(): array
    {
        $leads = Lead::count();
        $newLeads = Lead::where('status', 'baru')->count();

        return [
            Card::make('Total Prospek', $leads)
                ->description("{$newLeads} status Baru")
                ->descriptionIcon('heroicon-s-lightning-bolt')
                ->color('primary'),
            Card::make('Subscriber Aktif', NewsletterSubscriber::where('confirmed', true)->count())
                ->description('Newsletter double opt-in')
                ->descriptionIcon('heroicon-s-mail')
                ->color('success'),
            Card::make('Artikel Terbit', Post::where('status', 'published')->count())
                ->description('Blog')
                ->descriptionIcon('heroicon-s-document-text')
                ->color('warning'),
        ];
    }
}
