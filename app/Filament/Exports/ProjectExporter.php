<?php

namespace App\Filament\Exports;

use App\Models\Project;
use Filament\Actions\Exports\ExportColumn;
use Filament\Actions\Exports\Exporter;
use Filament\Actions\Exports\Models\Export;

class ProjectExporter extends Exporter
{
    protected static ?string $model = Project::class;

    public static function getColumns(): array
    {
        return [
            ExportColumn::make('title')->label('Titlu'),
            ExportColumn::make('slug')->label('Slug'),
            ExportColumn::make('summary')->label('Rezumat'),
            ExportColumn::make('client_name')->label('Client'),
            ExportColumn::make('industry')->label('Domeniu'),
            ExportColumn::make('challenge')->label('Provocare'),
            ExportColumn::make('solution')->label('Solutie'),
            ExportColumn::make('results')->label('Rezultate'),
            ExportColumn::make('demo_url')->label('Link demo'),
            ExportColumn::make('github_url')->label('Link GitHub'),
            ExportColumn::make('is_featured')->label('Recomandat'),
            ExportColumn::make('is_published')->label('Publicat'),
            ExportColumn::make('created_at')->label('Creat la'),
        ];
    }

    public static function getCompletedNotificationBody(Export $export): string
    {
        $body = 'Exportul proiectelor este gata. '.number_format($export->successful_rows).' '.str('rand')->plural($export->successful_rows).' au fost exportate.';

        if ($failedRowsCount = $export->getFailedRowsCount()) {
            $body .= ' '.number_format($failedRowsCount).' '.str('rand')->plural($failedRowsCount).' nu au putut fi exportate.';
        }

        return $body;
    }
}
