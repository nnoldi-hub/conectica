<?php

namespace App\Filament\Widgets;

use App\Models\ContactRequest;
use Filament\Widgets\ChartWidget;

class ContactRequestsByServiceChart extends ChartWidget
{
    protected ?string $heading = 'Cereri pe serviciu';

    protected static ?int $sort = 2;

    protected int|string|array $columnSpan = 1;

    protected function getType(): string
    {
        return 'doughnut';
    }

    protected function getData(): array
    {
        $grouped = ContactRequest::query()
            ->selectRaw("COALESCE(NULLIF(service, ''), 'Nespecificat') as service_label, COUNT(*) as total")
            ->groupBy('service_label')
            ->orderByDesc('total')
            ->pluck('total', 'service_label');

        return [
            'datasets' => [
                [
                    'data' => $grouped->values()->all(),
                    'backgroundColor' => ['#22d3ee', '#0891b2', '#0e7490', '#155e75', '#64748b', '#94a3b8'],
                ],
            ],
            'labels' => $grouped->keys()->all(),
        ];
    }
}
