<?php

namespace App\Filament\Resources\Cities\Schemas;

use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class CityForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                //
                TextInput::make('name')
                    ->label('City Name')
                    ->required()
                    ->maxLength(255),
                FileUpload::make('photo')
                    ->disk('public')
                    ->image()
                    ->required()
                    ->visibility('public'),
                    
            ]);
    }
}
