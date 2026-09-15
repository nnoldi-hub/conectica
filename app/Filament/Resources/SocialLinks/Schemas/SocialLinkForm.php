<?php

namespace App\Filament\Resources\SocialLinks\Schemas;

use App\Models\SocialLink;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;

class SocialLinkForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('platform')
                    ->label('Platforma')
                    ->options(SocialLink::platforms())
                    ->required()
                    ->native(false),
                TextInput::make('url')
                    ->label('Link profil')
                    ->url()
                    ->required()
                    ->placeholder('https://...'),
                TextInput::make('sort_order')
                    ->label('Ordine afisare')
                    ->required()
                    ->numeric()
                    ->default(0),
                Toggle::make('is_published')
                    ->label('Afisat pe site')
                    ->default(true)
                    ->required(),
            ]);
    }
}
