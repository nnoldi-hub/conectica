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
        $targetLabels = [
            'home_services' => 'Homepage · Servicii',
            'home_contact' => 'Homepage · Contact',
            'home_blog' => 'Homepage · Blog',
            'service_contact' => 'Serviciu · Contact',
            'service_all' => 'Serviciu · Toate serviciile',
            'service_final_contact' => 'Serviciu · CTA final',
            'project_final_contact' => 'Proiect · CTA final',
            'article_contact' => 'Articol · Contact',
            'article_services' => 'Articol · Servicii',
            'nav_contact' => 'Navigație · Contact',
            'mobile_nav_contact' => 'Meniu mobil · Contact',
            'footer_contact' => 'Footer · Contact',
        ];

        $grouped = ConversionEvent::query()
            ->where('event_name', 'cta_click')
            ->where('occurred_at', '>=', now()->subDays(30))
            ->selectRaw("COALESCE(NULLIF(target, ''), 'Nespecificat') as target_label, COUNT(*) as total")
            ->groupBy('target_label')
            ->orderByDesc('total')
            ->limit(10)
            ->pluck('total', 'target_label');

        $labels = $grouped->keys()->map(function (string $target) use ($targetLabels): string {
            if (isset($targetLabels[$target])) {
                return $targetLabels[$target];
            }

            foreach ([
                'services_list_details_' => 'Lista servicii · Detalii',
                'services_list_title_' => 'Lista servicii · Titlu',
                'projects_list_' => 'Lista proiecte',
                'blog_list_' => 'Lista blog',
                'project_demo_' => 'Proiect · Demo',
                'project_github_' => 'Proiect · Cod',
            ] as $prefix => $label) {
                if (str_starts_with($target, $prefix)) {
                    return $label.' · '.str_replace('-', ' ', substr($target, strlen($prefix)));
                }
            }

            return $target;
        })->all();

        return [
            'datasets' => [
                [
                    'label' => 'Clickuri',
                    'data' => $grouped->values()->all(),
                    'backgroundColor' => '#22d3ee',
                    'borderRadius' => 6,
                ],
            ],
            'labels' => $labels,
        ];
    }
}
