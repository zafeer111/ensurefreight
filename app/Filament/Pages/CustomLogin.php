<?php

namespace App\Filament\Pages;


use Chiiya\FilamentAccessControl\Http\Livewire\Login;
use Filament\Actions\Action;
use Filament\Forms\Components\TextInput;

class CustomLogin extends Login
{
    protected function getFormActions(): array
    {
        return [
            $this->getAuthenticateFormAction(),
            $this->getVendorRedirectButton(),
        ];
    }

    protected function getVendorRedirectButton(): Action
    {
        return Action::make('edit')
            ->color('gray')
            ->button()
            ->label('Redirect to Vendor Login')
            ->action(fn() => redirect()->route('customer.login'));
    }


}