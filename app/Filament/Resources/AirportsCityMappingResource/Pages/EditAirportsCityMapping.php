<?php

namespace App\Filament\Resources\AirportsCityMappingResource\Pages;

use App\Filament\Resources\AirportsCityMappingResource;
use Filament\Resources\Pages\EditRecord;

class EditAirportsCityMapping extends EditRecord
{
    protected static string $resource = AirportsCityMappingResource::class;

    protected function getHeaderActions(): array
    {
        return [
        ];
    }
}
