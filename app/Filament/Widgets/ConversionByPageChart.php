<?php

namespace App\Filament\Widgets;

use App\Models\ConversionEvent;
use Filament\Widgets\ChartWidget;

class ConversionByPageChart extends ChartWidget
{
    protected ?string $heading = 'Clickuri CTA după pagină (30 zile)';

    protected static ?int $sort = 4;

    protected int|string|array $columnSpan = 1;

    protected function getType(): string
    {
        return 'doughnut';
    }

    protected function getData(): array
    {
        $grouped = ConversionEvent::query()
            ->where('event_name', 'cta_click')
            ->where('occurred_at', '>=', now()->subDays(30))
            ->selectRaw('path, COUNT(*) as total')
            ->groupBy('path')
            ->orderByDesc('total')
            ->limit(8)
            ->pluck('total', 'path');

        return [
            'datasets' => [
                [
                    'data' => $grouped->values()->all(),
                    'backgroundColor' => ['#22d3ee', '#0891b2', '#0e7490', '#155e75', '#64748b', '#94a3b8', '#cbd5e1', '#e2e8f0'],
                ],
            ],
            'labels' => $grouped->keys()->all(),
        ];
    }
}
