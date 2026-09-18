<?php

namespace App\Filament\Widgets;

use App\Models\ConversionEvent;
use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class ConversionOverview extends StatsOverviewWidget
{
    protected static ?int $sort = 2;

    protected function getStats(): array
    {
        $lastSevenDays = now()->subDays(7);
        $lastThirtyDays = now()->subDays(30);

        $ctaClicks = ConversionEvent::query()
            ->where('event_name', 'cta_click')
            ->where('occurred_at', '>=', $lastSevenDays)
            ->count();
        $contactSubmissions = ConversionEvent::query()
            ->where('event_name', 'contact_submitted')
            ->where('occurred_at', '>=', $lastThirtyDays)
            ->count();
        $ctaClicksThirtyDays = ConversionEvent::query()
            ->where('event_name', 'cta_click')
            ->where('occurred_at', '>=', $lastThirtyDays)
            ->count();
        $facebookShares = ConversionEvent::query()
            ->where('event_name', 'facebook_share')
            ->where('occurred_at', '>=', $lastThirtyDays)
            ->count();
        $topPage = ConversionEvent::query()
            ->where('event_name', 'cta_click')
            ->where('occurred_at', '>=', $lastThirtyDays)
            ->select('path')
            ->groupBy('path')
            ->orderByRaw('COUNT(*) DESC')
            ->value('path');
        $conversionRate = $ctaClicksThirtyDays > 0
            ? number_format(($contactSubmissions / $ctaClicksThirtyDays) * 100, 1).'%'
            : 'N/A';
        $conversionSample = $ctaClicksThirtyDays > 0
            ? $contactSubmissions.' formular(e) / '.$ctaClicksThirtyDays.' click(uri)'
            : 'Niciun click CTA înregistrat';

        return [
            Stat::make('Clickuri CTA / 7 zile', $ctaClicks)
                ->description('interactiuni masurate local')
                ->color('info'),
            Stat::make('Formulare trimise / 30 zile', $contactSubmissions)
                ->description('solicitari valide salvate')
                ->color('success'),
            Stat::make('Distribuiri Facebook / 30 zile', $facebookShares)
                ->description('articole si pagini distribuite')
                ->color('warning'),
            Stat::make('Formulare / clickuri CTA', $conversionRate)
                ->description($conversionSample.' · ultimele 30 de zile')
                ->color('primary'),
            Stat::make('Pagina cu cele mai multe CTA', $topPage ?: 'Nicio conversie')
                ->description('in ultimele 30 de zile')
                ->color('primary'),
        ];
    }
}
