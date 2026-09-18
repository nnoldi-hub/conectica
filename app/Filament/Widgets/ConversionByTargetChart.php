<?php

namespace App\Filament\Widgets;

use App\Models\ConversionEvent;
use Filament\Widgets\ChartWidget;

class ConversionByTargetChart extends ChartWidget
{
    protected ?string $heading = 'Clickuri CTA după acțiune (30 zile)';

    protected static ?int $sort = 3;

    protected int|string|array $columnSpan = 1;

    protected function getType(): string
    {
        return 'bar';
    }

    protected function getData(): array
    {
        $grouped = ConversionEvent::query()
            ->where('event_name', 'cta_click')
            ->where('occurred_at', '>=', now()->subDays(30))
            ->selectRaw("COALESCE(NULLIF(target, ''), 'Nespecificat') as target_label, COUNT(*) as total")
            ->groupBy('target_label')
            ->orderByDesc('total')
            ->limit(10)
            ->pluck('total', 'target_label');

        return [
            'datasets' => [
                [
                    'label' => 'Clickuri',
                    'data' => $grouped->values()->all(),
                    'backgroundColor' => '#22d3ee',
                    'borderRadius' => 6,
                ],
            ],
            'labels' => $grouped->keys()->all(),
        ];
    }
}
