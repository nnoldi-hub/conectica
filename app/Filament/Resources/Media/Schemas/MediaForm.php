<?php

namespace App\Filament\Resources\Media\Schemas;

use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class MediaForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('title')
                    ->required()
                    ->maxLength(255),
                FileUpload::make('file_path')
                    ->label('Fisier imagine')
                    ->image()
                    ->disk('public')
                    ->directory('media')
                    ->required()
                    ->maxSize(5120)
                    ->acceptedFileTypes(['image/jpeg', 'image/png', 'image/webp']),
                TextInput::make('alt_text')
                    ->label('Text alternativ')
                    ->maxLength(255),
                TextInput::make('mime_type')
                    ->hidden()
                    ->default('image/*'),
                TextInput::make('size')
                    ->hidden()
                    ->numeric()
                    ->default(0),
                TextInput::make('disk')
                    ->hidden()
                    ->default('public'),
            ]);
    }
}
