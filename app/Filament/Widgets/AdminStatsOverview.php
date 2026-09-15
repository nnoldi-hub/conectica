<?php

namespace App\Filament\Widgets;

use App\Models\AuditLog;
use App\Models\ContactRequest;
use App\Models\Post;
use App\Models\Project;
use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class AdminStatsOverview extends StatsOverviewWidget
{
    protected function getStats(): array
    {
        return [
            Stat::make('Articole', Post::query()->count())
                ->description(Post::query()->where('is_published', true)->count().' publicate')
                ->color('info'),
            Stat::make('Proiecte', Project::query()->count())
                ->description(Project::query()->where('is_published', true)->count().' publicate')
                ->color('success'),
            Stat::make('Cereri de contact', ContactRequest::query()->count())
                ->description(ContactRequest::query()->where('status', 'new')->count().' noi')
                ->color('warning'),
            Stat::make('Actiuni recente', AuditLog::query()->where('created_at', '>=', now()->subDays(7))->count())
                ->description('in ultimele 7 zile')
                ->color('gray'),
        ];
    }
}
