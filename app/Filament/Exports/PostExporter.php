<?php

namespace App\Filament\Exports;

use App\Models\Post;
use Filament\Actions\Exports\ExportColumn;
use Filament\Actions\Exports\Exporter;
use Filament\Actions\Exports\Models\Export;

class PostExporter extends Exporter
{
    protected static ?string $model = Post::class;

    public static function getColumns(): array
    {
        return [
            ExportColumn::make('title')->label('Titlu'),
            ExportColumn::make('slug')->label('Slug'),
            ExportColumn::make('category.name')->label('Categorie'),
            ExportColumn::make('excerpt')->label('Rezumat'),
            ExportColumn::make('seo_title')->label('Titlu SEO'),
            ExportColumn::make('seo_description')->label('Descriere SEO'),
            ExportColumn::make('is_published')->label('Publicat'),
            ExportColumn::make('published_at')->label('Publicat la'),
            ExportColumn::make('created_at')->label('Creat la'),
        ];
    }

    public static function getCompletedNotificationBody(Export $export): string
    {
        $body = 'Exportul articolelor este gata. '.number_format($export->successful_rows).' '.str('rand')->plural($export->successful_rows).' au fost exportate.';

        if ($failedRowsCount = $export->getFailedRowsCount()) {
            $body .= ' '.number_format($failedRowsCount).' '.str('rand')->plural($failedRowsCount).' nu au putut fi exportate.';
        }

        return $body;
    }
}
