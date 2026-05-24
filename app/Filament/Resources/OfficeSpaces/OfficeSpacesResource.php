<?php

namespace App\Filament\Resources\OfficeSpaces;

use App\Filament\Resources\OfficeSpaces\Pages\CreateOfficeSpaces;
use App\Filament\Resources\OfficeSpaces\Pages\EditOfficeSpaces;
use App\Filament\Resources\OfficeSpaces\Pages\ListOfficeSpaces;
use App\Filament\Resources\OfficeSpaces\Schemas\OfficeSpacesForm;
use App\Filament\Resources\OfficeSpaces\Tables\OfficeSpacesTable;
use App\Models\OfficeSpaces;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class OfficeSpacesResource extends Resource
{
    protected static ?string $model = OfficeSpaces::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedBriefcase;

    public static function form(Schema $schema): Schema
    {
        return OfficeSpacesForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return OfficeSpacesTable::configure($table);
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
            'index' => ListOfficeSpaces::route('/'),
            'create' => CreateOfficeSpaces::route('/create'),
            'edit' => EditOfficeSpaces::route('/{record}/edit'),
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
