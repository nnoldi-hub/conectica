<?php

namespace App\Filament\Resources\Projects\Schemas;

use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\TagsInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class ProjectForm
{
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
                        TextInput::make('slug')
                            ->required()
                            ->unique(ignoreRecord: true)
                            ->columnSpan(1),
                        Textarea::make('summary')
                            ->label('Rezumat (afisat in lista de proiecte)')
                            ->required()
                            ->rows(3)
                            ->columnSpanFull(),
                        FileUpload::make('image_path')
                            ->label('Imagine principala')
                            ->image()
                            ->disk('public')
                            ->directory('projects')
                            ->maxSize(5120)
                            ->acceptedFileTypes(['image/jpeg', 'image/png', 'image/webp'])
                            ->columnSpanFull(),
                        TagsInput::make('technologies')
                            ->label('Tehnologii')
                            ->columnSpanFull(),
                    ]),
                Section::make('Studiu de caz (pagina de detaliu)')
                    ->description('Aceste informatii transforma proiectul intr-un caz convingator: problema clientului, ce am facut si ce a obtinut.')
                    ->columns(2)
                    ->components([
                        TextInput::make('client_name')
                            ->label('Client')
                            ->columnSpan(1),
                        TextInput::make('industry')
                            ->label('Domeniu / Industrie')
                            ->columnSpan(1),
                        Textarea::make('challenge')
                            ->label('Provocarea')
                            ->helperText('Ce problema avea clientul inainte de solutie?')
                            ->rows(3)
                            ->columnSpanFull(),
                        Textarea::make('solution')
                            ->label('Solutia')
                            ->helperText('Ce am construit si cum am rezolvat problema.')
                            ->rows(3)
                            ->columnSpanFull(),
                        Textarea::make('results')
                            ->label('Rezultatul')
                            ->helperText('Impact masurabil, daca este posibil (ex: -40% timp procesare, +25% comenzi).')
                            ->rows(3)
                            ->columnSpanFull(),
                        FileUpload::make('gallery')
                            ->label('Galerie imagini suplimentare')
                            ->image()
                            ->disk('public')
                            ->directory('projects/gallery')
                            ->multiple()
                            ->reorderable()
                            ->maxSize(5120)
                            ->acceptedFileTypes(['image/jpeg', 'image/png', 'image/webp'])
                            ->columnSpanFull(),
                    ]),
                Section::make('Testimonial')
                    ->components([
                        Textarea::make('testimonial_quote')
                            ->label('Citat client')
                            ->rows(2)
                            ->columnSpanFull(),
                        TextInput::make('testimonial_author')
                            ->label('Nume si functie')
                            ->placeholder('Ex: Ana Popescu, Fondator Fleetly')
                            ->columnSpanFull(),
                    ]),
                Section::make('Linkuri si publicare')
                    ->columns(2)
                    ->components([
                        TextInput::make('demo_url')
                            ->label('Link demo')
                            ->url(),
                        TextInput::make('github_url')
                            ->label('Link cod sursa')
                            ->url(),
                        TextInput::make('sort_order')
                            ->label('Ordine afisare')
                            ->required()
                            ->numeric()
                            ->default(0),
                        Toggle::make('is_featured')
                            ->label('Proiect recomandat (pe prima pagina)')
                            ->required(),
                        Toggle::make('is_published')
                            ->label('Publicat')
                            ->required()
                            ->disabled(fn (): bool => ! (auth()->user()?->canPublishContent() ?? false))
                            ->helperText(fn (): ?string => (auth()->user()?->canPublishContent() ?? false)
                                ? null
                                : 'Nu ai permisiunea de a publica. Proiectul ramane in asteptare pana e aprobat de un manager sau admin.'),
                    ]),
            ]);
    }
}
