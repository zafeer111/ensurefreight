<?php


namespace App\Filament\Resources;

use Carbon\Carbon;
use Chiiya\FilamentAccessControl\Enumerators\Feature;
use Chiiya\FilamentAccessControl\Fields\RoleSelect;
use Chiiya\FilamentAccessControl\Resources\FilamentUserResource;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\TextInput;
use Livewire\Component;

class CustomFilamentUserResource extends FilamentUserResource
{
    protected static function detailsSectionSchema(): array
    {
        return [
            TextInput::make('first_name')
                ->label(__('filament-access-control::default.fields.first_name'))
                ->validationAttribute(__('filament-access-control::default.fields.first_name'))
                ->required(),
            TextInput::make('last_name')
                ->label(__('filament-access-control::default.fields.last_name'))
                ->validationAttribute(__('filament-access-control::default.fields.last_name'))
                ->required(),
            TextInput::make('email')
                ->label(__('filament-access-control::default.fields.email'))
                ->validationAttribute(__('filament-access-control::default.fields.email'))
                // ->unique()
                ->unique(ignoreRecord: true)
                ->required()
                ->email(),
            RoleSelect::make('role')
                ->label(__('filament-access-control::default.fields.role'))
                ->validationAttribute(__('filament-access-control::default.fields.role')),
            ...(
            Feature::enabled(Feature::ACCOUNT_EXPIRY)
                ? [
                DatePicker::make('expires_at')
                    ->label(__('filament-access-control::default.fields.expires_at'))
                    ->validationAttribute(__('filament-access-control::default.fields.expires_at'))
                    ->minDate(fn (Component $livewire) => static::evaluateMinDate($livewire))
                    ->displayFormat(config('filament-access-control.date_format'))
                    ->dehydrateStateUsing(
                        fn ($state) => Carbon::parse($state)->endOfDay()->toDateTimeString(),
                    ),
            ]
                : []
            ),
        ];
    }
}