<?php

namespace App\Filament\Widgets;

use App\Models\AuditLog;
use App\Models\Post;
use App\Models\Project;
use App\Models\Service;
use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Illuminate\Support\Facades\Route;

class SeoPerformanceOverview extends StatsOverviewWidget
{
    protected function getStats(): array
    {
        $indexedPages = 4
            + Service::query()->published()->count()
            + Project::query()->published()->count()
            + Post::query()->published()->count();

        $lastAudit = AuditLog::query()->latest()->value('created_at');

        return [
            Stat::make('Pagini indexabile', $indexedPages)
                ->description('incluse in sitemap')
                ->color('success'),
            Stat::make('Sitemap', Route::has('seo.sitemap') ? 'Activ' : 'Indisponibil')
                ->description('sitemap.xml')
                ->color(Route::has('seo.sitemap') ? 'success' : 'danger'),
            Stat::make('Ultimul audit', $lastAudit ? date('d.m.Y H:i', strtotime($lastAudit)) : 'Nicio actiune')
                ->description('ultima activitate inregistrata')
                ->color('info'),
        ];
    }
}
