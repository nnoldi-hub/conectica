<?php

namespace App\Filament\Widgets;

use App\Models\ContactRequest;
use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class CommunicationOverview extends StatsOverviewWidget
{
    protected static ?int $sort = 0;

    protected function getStats(): array
    {
        $new = ContactRequest::query()->where('status', 'new')->count();
        $inProgress = ContactRequest::query()->whereIn('status', ['reviewing', 'contacted'])->count();
        $resolved = ContactRequest::query()->whereIn('status', ['converted', 'closed'])->count();

        return [
            Stat::make('Cereri noi', $new)
                ->description('Asteapta un raspuns')
                ->color($new > 0 ? 'warning' : 'success'),
            Stat::make('In lucru', $inProgress)
                ->description('In analiza sau contactate')
                ->color('info'),
            Stat::make('Rezolvate', $resolved)
                ->description('Convertite sau inchise')
                ->color('success'),
        ];
    }
}
