<?php

namespace App\Filament\Exports;

use App\Models\ContactRequest;
use Filament\Actions\Exports\ExportColumn;
use Filament\Actions\Exports\Exporter;
use Filament\Actions\Exports\Models\Export;

class ContactRequestExporter extends Exporter
{
    protected static ?string $model = ContactRequest::class;

    public static function getColumns(): array
    {
        return [
            ExportColumn::make('name')->label('Nume'),
            ExportColumn::make('email')->label('Email'),
            ExportColumn::make('phone')->label('Telefon'),
            ExportColumn::make('service')->label('Serviciu'),
            ExportColumn::make('budget')->label('Buget'),
            ExportColumn::make('message')->label('Mesaj'),
            ExportColumn::make('status')
                ->label('Status')
                ->formatStateUsing(fn (?string $state): string => ContactRequest::STATUSES[$state] ?? $state ?? ''),
            ExportColumn::make('contacted_at')->label('Contactat la'),
            ExportColumn::make('created_at')->label('Creat la'),
        ];
    }

    public static function getCompletedNotificationBody(Export $export): string
    {
        $body = 'Exportul cererilor de contact este gata. '.number_format($export->successful_rows).' '.str('rand')->plural($export->successful_rows).' au fost exportate.';

        if ($failedRowsCount = $export->getFailedRowsCount()) {
            $body .= ' '.number_format($failedRowsCount).' '.str('rand')->plural($failedRowsCount).' nu au putut fi exportate.';
        }

        return $body;
    }
}
