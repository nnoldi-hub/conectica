<?php

namespace App\Filament\Widgets;

use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class SystemOverview extends StatsOverviewWidget
{
    protected function getStats(): array
    {
        return [
            Stat::make('Laravel', app()->version())->color('danger'),
            Stat::make('PHP', PHP_VERSION)->color('info'),
            Stat::make('Queue', config('queue.default'))
                ->description('driver configurat')
                ->color('success'),
            Stat::make('Cache', config('cache.default'))
                ->description('driver configurat')
                ->color('success'),
        ];
    }
}
