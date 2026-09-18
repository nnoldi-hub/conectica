<?php

namespace App\Providers\Filament;

use App\Filament\Pages\Dashboard;
use App\Filament\Widgets\AdminStatsOverview;
use App\Filament\Widgets\AnalyticsOverview;
use App\Filament\Widgets\CommunicationOverview;
use App\Filament\Widgets\ContactRequestsByServiceChart;
use App\Filament\Widgets\ContactRequestsPerDayChart;
use App\Filament\Widgets\ConversionOverview;
use App\Filament\Widgets\QuickActions;
use App\Filament\Widgets\SeoPerformanceOverview;
use App\Filament\Widgets\SystemOverview;
use Filament\Auth\MultiFactor\App\AppAuthentication;
use Filament\Http\Middleware\Authenticate;
use Filament\Http\Middleware\AuthenticateSession;
use Filament\Http\Middleware\DisableBladeIconComponents;
use Filament\Http\Middleware\DispatchServingFilamentEvent;
use Filament\Navigation\NavigationGroup;
use Filament\Panel;
use Filament\PanelProvider;
use Filament\Support\Colors\Color;
use Filament\Widgets\AccountWidget;
use Filament\Widgets\FilamentInfoWidget;
use Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse;
use Illuminate\Cookie\Middleware\EncryptCookies;
use Illuminate\Foundation\Http\Middleware\PreventRequestForgery;
use Illuminate\Routing\Middleware\SubstituteBindings;
use Illuminate\Session\Middleware\StartSession;
use Illuminate\View\Middleware\ShareErrorsFromSession;

class AdminPanelProvider extends PanelProvider
{
    public function panel(Panel $panel): Panel
    {
        return $panel
            ->default()
            ->id('admin')
            ->path('admin')
            ->login()
            ->profile()
            ->multiFactorAuthentication([
                AppAuthentication::make(),
            ])
            ->brandName('Conectica IT · Arhitectură. Claritate. Control.')
            ->brandLogo(asset('logo_symbol.png'))
            ->brandLogoHeight('2.5rem')
            ->databaseNotifications()
            ->databaseNotificationsPolling('30s')
            ->colors([
                'primary' => Color::Cyan,
            ])
            ->navigationGroups([
                NavigationGroup::make('Continut site')->collapsible(false),
                NavigationGroup::make('Comunicare')->collapsible(false),
                NavigationGroup::make('Sistem')->collapsible(false),
            ])
            ->discoverResources(in: app_path('Filament/Resources'), for: 'App\Filament\Resources')
            ->discoverPages(in: app_path('Filament/Pages'), for: 'App\Filament\Pages')
            ->pages([
                Dashboard::class,
            ])
            ->discoverWidgets(in: app_path('Filament/Widgets'), for: 'App\Filament\Widgets')
            ->widgets([
                AccountWidget::class,
                AdminStatsOverview::class,
                ConversionOverview::class,
                CommunicationOverview::class,
                ContactRequestsPerDayChart::class,
                ContactRequestsByServiceChart::class,
                QuickActions::class,
                SystemOverview::class,
                SeoPerformanceOverview::class,
                AnalyticsOverview::class,
                FilamentInfoWidget::class,
            ])
            ->middleware([
                EncryptCookies::class,
                AddQueuedCookiesToResponse::class,
                StartSession::class,
                AuthenticateSession::class,
                ShareErrorsFromSession::class,
                PreventRequestForgery::class,
                SubstituteBindings::class,
                DisableBladeIconComponents::class,
                DispatchServingFilamentEvent::class,
            ])
            ->authMiddleware([
                Authenticate::class,
            ]);
    }
}
