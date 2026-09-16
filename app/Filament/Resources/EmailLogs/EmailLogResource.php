<?php

namespace App\Filament\Resources\EmailLogs;

use App\Filament\Resources\EmailLogs\Pages\ListEmailLogs;
use App\Models\EmailLog;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;

class EmailLogResource extends Resource
{
    protected static ?string $model = EmailLog::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedPaperAirplane;

    public static function getNavigationGroup(): ?string
    {
        return 'Comunicare';
    }

    public static function getNavigationSort(): ?int
    {
        return 2;
    }

    public static function getNavigationLabel(): string
    {
        return 'Emailuri trimise';
    }

    public static function getModelLabel(): string
    {
        return 'email';
    }

    public static function getPluralModelLabel(): string
    {
        return 'emailuri';
    }

    public static function canCreate(): bool
    {
        return false;
    }

    public static function canEdit($record): bool
    {
        return false;
    }

    public static function canDelete($record): bool
    {
        return false;
    }

    public static function form(Schema $schema): Schema
    {
        return $schema;
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('created_at')->label('Data')->dateTime()->sortable(),
                TextColumn::make('to_email')->label('Destinatar')->searchable(),
                TextColumn::make('subject')->label('Subiect')->searchable()->wrap(),
                TextColumn::make('status')
                    ->label('Status')
                    ->badge()
                    ->formatStateUsing(fn (string $state): string => EmailLog::STATUSES[$state] ?? $state)
                    ->color(fn (string $state): string => match ($state) {
                        'opened' => 'success',
                        'sent' => 'info',
                        'failed' => 'danger',
                        default => 'gray',
                    }),
                TextColumn::make('sent_at')->label('Trimis la')->dateTime()->sortable()->placeholder('—'),
                TextColumn::make('opened_at')->label('Deschis la')->dateTime()->sortable()->placeholder('—'),
            ])
            ->defaultSort('created_at', 'desc')
            ->filters([
                SelectFilter::make('status')
                    ->label('Status')
                    ->options(EmailLog::STATUSES),
            ])
            ->recordActions([])
            ->toolbarActions([]);
    }

    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListEmailLogs::route('/'),
        ];
    }
}
