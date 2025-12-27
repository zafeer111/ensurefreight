<?php

namespace App\Filament\Resources\AirportsCityMappingResource\Pages;

use App\Filament\Resources\AirportsCityMappingResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListAirportsCityMappings extends ListRecords
{
    protected static string $resource = AirportsCityMappingResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
