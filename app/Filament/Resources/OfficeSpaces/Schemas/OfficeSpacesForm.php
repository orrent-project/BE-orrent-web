<?php

namespace App\Filament\Resources\OfficeSpaces\Schemas;

use Dom\Text;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class OfficeSpacesForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                //
                TextInput::make('name')
                    ->required()
                    ->maxLength(255),
                TextInput::make('address')
                    ->required()
                    ->maxLength(255),
                FileUpload::make('thumbnail')
                    ->image()
                    ->disk('public')
                    ->visibility('public')
                    ->required(),
                Textarea::make('about')
                    ->required()
                    ->rows(10)
                    ->cols(20),
                    
                // Di bawah ini digunakan repeater untuk menambahkan data lebih dari satu (dalam hal ini foto dan benefit)
                Repeater::make('photos')
                    ->relationship('photos') //karena berelasi dengan model photos, yang nantinya akan tersimpan di tabel office_space_photos
                    ->schema([
                        FileUpload::make('photo')
                            ->disk('public')
                            ->visibility('public')
                            ->required(),
                    ]),
                Repeater::make('benefits')
                    ->relationship('benefits') //karena berelasi dengan model benefits, yang nantinya akan tersimpan di tabel office_space_benefits
                    ->schema([
                        TextInput::make('name')
                            ->required()
                    ]),
                Select::make('city_id')
                    ->relationship('city', 'name') //penggunaan relationship pada Select berbeda dengan Repeater
                    ->searchable()
                    ->preload()
                    ->required(),
                TextInput::make('price')
                    ->required()
                    ->numeric()
                    ->prefix('IDR'),
                TextInput::make('duration')
                    ->required()
                    ->numeric()
                    ->prefix('Days'),
                Select::make('is_open')
                    ->options([
                        true => 'Open',
                        false => 'Not Open',
                    ])
                    ->required(),
                Select::make('is_full_booked')
                    ->options([
                        true => 'Not Available',
                        false => 'Available',
                    ])
                    ->required(),
            ]);
    }
}
