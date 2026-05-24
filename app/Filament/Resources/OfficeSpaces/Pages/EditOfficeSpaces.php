<?php

namespace App\Filament\Resources\OfficeSpaces\Pages;

use App\Filament\Resources\OfficeSpaces\OfficeSpacesResource;
use Filament\Actions\DeleteAction;
use Filament\Actions\ForceDeleteAction;
use Filament\Actions\RestoreAction;
use Filament\Resources\Pages\EditRecord;

class EditOfficeSpaces extends EditRecord
{
    protected static string $resource = OfficeSpacesResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
            ForceDeleteAction::make(),
            RestoreAction::make(),
        ];
    }
}
