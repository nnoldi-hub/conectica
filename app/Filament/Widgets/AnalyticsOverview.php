<?php

namespace App\Filament\Widgets;

use App\Models\PageView;
use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class AnalyticsOverview extends StatsOverviewWidget
{
    protected function getStats(): array
    {
        $since = now()->subDays(7);
        $views = PageView::query()->where('viewed_at', '>=', $since);
        $popularPage = (clone $views)->select('path')->groupBy('path')->orderByRaw('COUNT(*) DESC')->value('path');
        $topSource = (clone $views)->whereNotNull('referrer_host')->select('referrer_host')->groupBy('referrer_host')->orderByRaw('COUNT(*) DESC')->value('referrer_host');

        return [
            Stat::make('Vizite / 7 zile', (clone $views)->count())
                ->description('masurate local, fara IP')
                ->color('info'),
            Stat::make('Pagina populara', $popularPage ?: 'Nicio vizita')
                ->description('dupa numarul de vizualizari')
                ->color('success'),
            Stat::make('Sursa principala', $topSource ?: 'Direct')
                ->description('referrer disponibil')
                ->color('warning'),
        ];
    }
}
