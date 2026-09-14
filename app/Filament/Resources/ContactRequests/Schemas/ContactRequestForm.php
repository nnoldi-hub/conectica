<?php

namespace App\Filament\Resources\ContactRequests\Schemas;

use App\Models\ContactRequest;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class ContactRequestForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name')->required(),
                TextInput::make('email')->email()->required(),
                TextInput::make('phone'),
                TextInput::make('service'),
                TextInput::make('budget'),
                Textarea::make('message')->required()->columnSpanFull(),
                Select::make('status')
                    ->options(ContactRequest::STATUSES)
                    ->required(),
                DateTimePicker::make('contacted_at'),
            ]);
    }
}
