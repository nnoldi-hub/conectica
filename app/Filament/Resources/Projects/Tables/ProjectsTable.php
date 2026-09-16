<?php

namespace App\Filament\Resources\Projects\Tables;

use App\Filament\Exports\ProjectExporter;
use App\Filament\Resources\Projects\ProjectResource;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\Exports\Enums\ExportFormat;
use Filament\Actions\ExportAction;
use Filament\Actions\ExportBulkAction;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class ProjectsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('title')
                    ->label('Titlu')
                    ->searchable(),
                TextColumn::make('client_name')
                    ->label('Client')
                    ->placeholder('—')
                    ->searchable(),
                TextColumn::make('industry')
                    ->label('Domeniu')
                    ->placeholder('—'),
                TextColumn::make('sort_order')
                    ->label('Ordine')
                    ->numeric()
                    ->sortable(),
                IconColumn::make('is_featured')
                    ->label('Recomandat')
                    ->boolean(),
                IconColumn::make('is_published')
                    ->label('Publicat')
                    ->boolean(),
                TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->headerActions([
                ExportAction::make()
                    ->label('Export CSV')
                    ->exporter(ProjectExporter::class)
                    ->formats([ExportFormat::Csv]),
            ])
            ->recordActions([
                EditAction::make()
                    ->visible(fn ($record): bool => ProjectResource::canEdit($record)),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    ExportBulkAction::make()
                        ->label('Export CSV')
                        ->exporter(ProjectExporter::class)
                        ->formats([ExportFormat::Csv]),
                    DeleteBulkAction::make()
                        ->visible(fn (): bool => auth()->user()?->canDeleteContent() ?? false),
                ]),
            ]);
    }
}
