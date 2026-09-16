<?php

namespace App\Filament\Resources\Services\Schemas;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\TagsInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class ServiceForm
{
    protected static function iconOptions(): array
    {
        return [
            'heroicon-o-code-bracket' => 'Cod / Dezvoltare',
            'heroicon-o-cog-6-tooth' => 'Automatizare',
            'heroicon-o-rocket-launch' => 'Lansare produs',
            'heroicon-o-cube' => 'Produs software',
            'heroicon-o-device-phone-mobile' => 'Mobil',
            'heroicon-o-globe-alt' => 'Web',
            'heroicon-o-server' => 'Infrastructura',
            'heroicon-o-shield-check' => 'Securitate',
            'heroicon-o-chart-bar' => 'Analiza / Rapoarte',
            'heroicon-o-bolt' => 'Performanta',
        ];
    }

    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Continut principal')
                    ->columns(2)
                    ->components([
                        TextInput::make('title')
                            ->label('Titlu')
                            ->required()
                            ->columnSpan(1),
                        Select::make('icon')
                            ->label('Iconita')
                            ->options(self::iconOptions())
                            ->native(false)
                            ->columnSpan(1),
                        TextInput::make('slug')
                            ->required()
                            ->unique(ignoreRecord: true)
                            ->columnSpanFull(),
                        Textarea::make('description')
                            ->label('Descriere')
                            ->required()
                            ->rows(3)
                            ->columnSpanFull(),
                    ]),
                Section::make('Ce convinge un client')
                    ->description('Beneficii clare, punctate, care raspund la "de ce as alege acest serviciu?".')
                    ->components([
                        TagsInput::make('highlights')
                            ->label('Ce include (beneficii)')
                            ->placeholder('Adauga un beneficiu si apasa Enter')
                            ->columnSpanFull(),
                        TextInput::make('price_note')
                            ->label('Nota de pret')
                            ->placeholder('Ex: De la 1.500 EUR sau Oferta personalizata')
                            ->columnSpanFull(),
                    ]),
                Section::make('Publicare')
                    ->columns(2)
                    ->components([
                        TextInput::make('sort_order')
                            ->label('Ordine afisare')
                            ->required()
                            ->numeric()
                            ->default(0),
                        Toggle::make('is_published')
                            ->label('Publicat')
                            ->required()
                            ->disabled(fn (): bool => ! (auth()->user()?->canPublishContent() ?? false))
                            ->helperText(fn (): ?string => (auth()->user()?->canPublishContent() ?? false)
                                ? null
                                : 'Nu ai permisiunea de a publica. Serviciul ramane in asteptare pana e aprobat de un manager sau admin.'),
                    ]),
            ]);
    }
}
