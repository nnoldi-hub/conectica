<?php

namespace App\Filament\Resources\ContactRequests\Tables;

use App\Filament\Exports\ContactRequestExporter;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\Exports\Enums\ExportFormat;
use Filament\Actions\ExportAction;
use Filament\Actions\ExportBulkAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class ContactRequestsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')->searchable()->sortable(),
                TextColumn::make('email')->searchable(),
                TextColumn::make('service')->badge(),
                TextColumn::make('status')->badge()->sortable(),
                TextColumn::make('created_at')->dateTime()->sortable(),
            ])
            ->filters([
                //
            ])
            ->headerActions([
                ExportAction::make()
                    ->label('Export CSV')
                    ->exporter(ContactRequestExporter::class)
                    ->formats([ExportFormat::Csv]),
            ])
            ->recordActions([
                EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    ExportBulkAction::make()
                        ->label('Export CSV')
                        ->exporter(ContactRequestExporter::class)
                        ->formats([ExportFormat::Csv]),
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
