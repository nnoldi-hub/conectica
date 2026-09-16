<?php

namespace App\Filament\Resources\Posts\Tables;

use App\Filament\Exports\PostExporter;
use App\Filament\Resources\Posts\PostResource;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\Exports\Enums\ExportFormat;
use Filament\Actions\ExportAction;
use Filament\Actions\ExportBulkAction;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class PostsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('post_category_id')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('title')
                    ->searchable(),
                TextColumn::make('slug')
                    ->searchable(),
                TextColumn::make('excerpt')
                    ->searchable(),
                TextColumn::make('seo_title')
                    ->searchable(),
                TextColumn::make('seo_description')
                    ->searchable(),
                TextColumn::make('published_at')
                    ->dateTime()
                    ->sortable(),
                IconColumn::make('is_published')
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
                    ->exporter(PostExporter::class)
                    ->formats([ExportFormat::Csv]),
            ])
            ->recordActions([
                EditAction::make()
                    ->visible(fn ($record): bool => PostResource::canEdit($record)),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    ExportBulkAction::make()
                        ->label('Export CSV')
                        ->exporter(PostExporter::class)
                        ->formats([ExportFormat::Csv]),
                    DeleteBulkAction::make()
                        ->visible(fn (): bool => auth()->user()?->canDeleteContent() ?? false),
                ]),
            ]);
    }
}
