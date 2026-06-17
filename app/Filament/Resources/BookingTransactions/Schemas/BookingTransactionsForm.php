<?php

namespace App\Filament\Resources\BookingTransactions\Schemas;

use Carbon\Carbon;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Utilities\Get;
use Filament\Schemas\Components\Utilities\Set;
use Filament\Schemas\Schema;

class BookingTransactionsForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                //
                TextInput::make('name')
                    ->required()
                    ->maxLength(255),
                TextInput::make('booking_trx')
                    ->label('Booking trx id')
                    ->required()
                    ->maxLength(255),
                TextInput::make('phone_number')
                    ->required()
                    ->maxLength(255),
                TextInput::make('total_amount')
                    ->required()
                    ->numeric()
                    ->prefix('IDR'),
                TextInput::make('duration')
                    ->required()
                    ->numeric()
                    ->prefix('Days')
                    ->reactive()
                    ->afterStateUpdated(function (?int $state, Set $set, Get $get): void {
                        $startedAt = $get('started_at');

                        if (! $state || ! $startedAt) {
                            return;
                        }

                        $set('ended_at', Carbon::parse($startedAt)
                            ->addDays((int) $state)
                            ->format('Y-m-d'));
                    }),
                DatePicker::make('started_at')
                    ->required()
                    ->reactive()
                    ->afterStateUpdated(function (?string $state, Set $set, Get $get): void {
                        $duration = $get('duration');

                        if (! $state || ! $duration) {
                            return;
                        }

                        $set('ended_at', Carbon::parse($state)
                            ->addDays((int) $duration)
                            ->format('Y-m-d'));
                    }),
                DatePicker::make('ended_at')
                    ->label('Expired at')
                    ->required(),
                Select::make('is_paid')
                    ->options([
                        true => 'Paid',
                        false => 'Not Paid',
                    ])
                    ->required(),
                Select::make('office_space_id')
                    ->relationship('officeSpace', 'name')
                    ->searchable()
                    ->preload()
                    ->required(),
            ]);
    }
}
