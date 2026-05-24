<?php

namespace App\Filament\Resources\BookingTransactions;

use App\Filament\Resources\BookingTransactions\Pages\CreateBookingTransactions;
use App\Filament\Resources\BookingTransactions\Pages\EditBookingTransactions;
use App\Filament\Resources\BookingTransactions\Pages\ListBookingTransactions;
use App\Filament\Resources\BookingTransactions\Schemas\BookingTransactionsForm;
use App\Filament\Resources\BookingTransactions\Tables\BookingTransactionsTable;
use App\Models\BookingTransactions;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class BookingTransactionsResource extends Resource
{
    protected static ?string $model = BookingTransactions::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedCreditCard;

    public static function form(Schema $schema): Schema
    {
        return BookingTransactionsForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return BookingTransactionsTable::configure($table);
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
            'index' => ListBookingTransactions::route('/'),
            'create' => CreateBookingTransactions::route('/create'),
            'edit' => EditBookingTransactions::route('/{record}/edit'),
        ];
    }

    public static function getRecordRouteBindingEloquentQuery(): Builder
    {
        return parent::getRecordRouteBindingEloquentQuery()
            ->withoutGlobalScopes([
                SoftDeletingScope::class,
            ]);
    }
}
