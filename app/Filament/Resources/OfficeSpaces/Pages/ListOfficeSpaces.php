<?php

namespace App\Filament\Resources\OfficeSpaces\Pages;

use App\Filament\Resources\OfficeSpaces\OfficeSpacesResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListOfficeSpaces extends ListRecords
{
    protected static string $resource = OfficeSpacesResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
