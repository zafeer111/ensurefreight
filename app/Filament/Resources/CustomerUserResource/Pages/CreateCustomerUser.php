<?php

namespace App\Filament\Resources\CustomerUserResource\Pages;

use App\Filament\Resources\CustomerUserResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateCustomerUser extends CreateRecord
{
    protected static string $resource = CustomerUserResource::class;
}
