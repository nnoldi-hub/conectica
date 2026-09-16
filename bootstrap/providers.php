<?php

use App\Providers\AppServiceProvider;
use App\Providers\Filament\AdminPanelProvider;
use Barryvdh\DomPDF\ServiceProvider as DomPdfServiceProvider;

return [
    AppServiceProvider::class,
    AdminPanelProvider::class,
    DomPdfServiceProvider::class,
];
