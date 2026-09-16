<?php

namespace App\Filament\Resources\ContactRequests;

use App\Filament\Resources\ContactRequests\Pages\CreateContactRequest;
use App\Filament\Resources\ContactRequests\Pages\EditContactRequest;
use App\Filament\Resources\ContactRequests\Pages\ListContactRequests;
use App\Filament\Resources\ContactRequests\Schemas\ContactRequestForm;
use App\Filament\Resources\ContactRequests\Tables\ContactRequestsTable;
use App\Models\ContactRequest;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class ContactRequestResource extends Resource
{
    protected static ?string $model = ContactRequest::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedEnvelope;

    public static function getNavigationGroup(): ?string
    {
        return 'Comunicare';
    }

    public static function getNavigationSort(): ?int
    {
        return 1;
    }

    public static function getNavigationLabel(): string
    {
        return 'Cereri de contact';
    }

    public static function getModelLabel(): string
    {
        return 'cerere de contact';
    }

    public static function getPluralModelLabel(): string
    {
        return 'cereri de contact';
    }

    public static function canCreate(): bool
    {
        return false;
    }

    public static function canEdit($record): bool
    {
        return auth()->user()?->canManageContactRequests() ?? false;
    }

    public static function canDelete($record): bool
    {
        return auth()->user()?->canDeleteContent() ?? false;
    }

    public static function form(Schema $schema): Schema
    {
        return ContactRequestForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return ContactRequestsTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListContactRequests::route('/'),
            'create' => CreateContactRequest::route('/create'),
            'edit' => EditContactRequest::route('/{record}/edit'),
        ];
    }
}
