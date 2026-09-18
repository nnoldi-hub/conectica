<?php

namespace App\Filament\Resources\Posts\Schemas;

use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TagsInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class PostForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Identitate articol')
                    ->description('Titlul si rezumatul apar in lista blogului si in rezultatele de cautare.')
                    ->columns(2)
                    ->components([
                        TextInput::make('title')
                            ->label('Titlu')
                            ->required()
                            ->live(onBlur: true)
                            ->columnSpanFull(),
                        Select::make('post_category_id')
                            ->label('Categorie')
                            ->relationship('category', 'name')
                            ->searchable()
                            ->preload(),
                        TextInput::make('slug')
                            ->label('Slug URL')
                            ->helperText('Se foloseste in adresa articolului. Foloseste litere mici si cratime.')
                            ->required()
                            ->unique(ignoreRecord: true),
                        Textarea::make('excerpt')
                            ->label('Rezumat scurt')
                            ->helperText('1-2 fraze care explica problema si motivul pentru care merita citit articolul.')
                            ->required()
                            ->rows(3)
                            ->columnSpanFull(),
                    ]),
                Section::make('Conținut articol')
                    ->description('Scrie fiecare paragraf separat. Folosește Enter pentru paragraf nou, H2 pentru secțiuni principale și H3 pentru subsecțiuni.')
                    ->components([
                        RichEditor::make('body')
                            ->label('Conținut')
                            ->required()
                            ->toolbarButtons([
                                'bold',
                                'italic',
                                'underline',
                                'strike',
                                'subscript',
                                'superscript',
                                'link',
                                'h2',
                                'h3',
                                'blockquote',
                                'bulletList',
                                'orderedList',
                                'table',
                                'undo',
                                'redo',
                            ])
                            ->helperText('Recomandare: începe cu o introducere, adaugă subtitluri H2 pentru ideile mari și încheie cu o concluzie. Articolele vechi cu ## și ### rămân compatibile.')
                            ->columnSpanFull(),
                    ]),
                Section::make('Imagine și clasificare')
                    ->columns(2)
                    ->components([
                        FileUpload::make('image_path')
                            ->label('Imagine articol')
                            ->image()
                            ->disk('public')
                            ->directory('posts')
                            ->maxSize(5120)
                            ->acceptedFileTypes(['image/jpeg', 'image/png', 'image/webp'])
                            ->helperText('Folosește JPG, PNG sau WebP, maximum 5 MB.')
                            ->columnSpan(1),
                        TagsInput::make('tags')
                            ->label('Etichete')
                            ->placeholder('Adaugă o etichetă')
                            ->helperText('Apasă Enter după fiecare etichetă. Folosește termeni relevanți pentru subiect.')
                            ->columnSpan(1),
                    ]),
                Section::make('SEO')
                    ->description('Câmpurile sunt opționale. Dacă rămân goale, site-ul folosește titlul și rezumatul articolului.')
                    ->columns(2)
                    ->components([
                        TextInput::make('seo_title')
                            ->label('Titlu SEO')
                            ->maxLength(255)
                            ->helperText('Ideal: aproximativ 50-60 de caractere.')
                            ->columnSpan(1),
                        Textarea::make('seo_description')
                            ->label('Descriere SEO')
                            ->maxLength(500)
                            ->rows(2)
                            ->helperText('Descriere clară pentru Google, ideal în jur de 150-160 de caractere.')
                            ->columnSpan(1),
                    ]),
                Section::make('Publicare')
                    ->columns(2)
                    ->components([
                        DateTimePicker::make('published_at')
                            ->label('Data publicării')
                            ->helperText('Folosită pentru afișare și schema Article.'),
                        Toggle::make('is_published')
                            ->label('Publicat')
                            ->required()
                            ->disabled(fn (): bool => ! (auth()->user()?->canPublishContent() ?? false))
                            ->helperText(fn (): ?string => (auth()->user()?->canPublishContent() ?? false)
                                ? 'Articolul va fi vizibil pe site.'
                                : 'Nu ai permisiunea de a publica. Articolul rămâne în așteptare până este aprobat de un manager sau administrator.'),
                    ]),
            ]);
    }
}
