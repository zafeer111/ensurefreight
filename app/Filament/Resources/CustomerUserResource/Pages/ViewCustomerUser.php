<?php

namespace App\Filament\Resources\CustomerUserResource\Pages;

use App\Filament\Resources\CustomerUserResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;

class ViewCustomerUser extends ViewRecord
{
    protected static string $resource = CustomerUserResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\EditAction::make(),
        ];
    }
}
