<?php

namespace App\Filament\Widgets;

use App\Models\ContactRequest;
use Filament\Widgets\ChartWidget;

class ContactRequestsPerDayChart extends ChartWidget
{
    protected ?string $heading = 'Cereri de contact pe zi (ultimele 14 zile)';

    protected static ?int $sort = 1;

    protected int|string|array $columnSpan = 1;

    protected function getType(): string
    {
        return 'bar';
    }

    protected function getData(): array
    {
        $days = collect(range(13, 0))->map(fn (int $offset) => now()->subDays($offset)->startOfDay());

        $counts = ContactRequest::query()
            ->selectRaw('DATE(created_at) as day, COUNT(*) as total')
            ->where('created_at', '>=', now()->subDays(13)->startOfDay())
            ->groupBy('day')
            ->pluck('total', 'day');

        return [
            'datasets' => [
                [
                    'label' => 'Cereri',
                    'data' => $days->map(fn ($day) => (int) ($counts[$day->format('Y-m-d')] ?? 0))->all(),
                    'backgroundColor' => '#22d3ee',
                    'borderRadius' => 6,
                ],
            ],
            'labels' => $days->map(fn ($day) => $day->format('d.m'))->all(),
        ];
    }
}
