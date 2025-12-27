<?php

namespace App\Filament\Resources;

use App\Filament\Resources\CustomerUserResource\Pages;
use App\Filament\Resources\CustomerUserResource\RelationManagers;
use App\Models\City;
use App\Models\Customer;
use Filament\Forms\Components\Toggle;
use App\Models\CustomerUser;
use App\Models\State;
use Filament\Forms;
use Filament\Forms\Components\Component;
use Filament\Forms\Form;
use Illuminate\Support\Facades\Hash;
use Filament\Forms\Get;
use Illuminate\Support\Collection;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Pages\Page;
use Filament\Resources\Pages\CreateRecord;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class CustomerUserResource extends Resource
{
    protected static ?string $model = CustomerUser::class;

    protected static ?string $navigationIcon = 'heroicon-m-user-group';
    protected static ?string $navigationGroup = 'Companies or Individuals';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('customer_id')
                    ->label('Customer')
                    ->searchable()
                    ->options(Customer::pluck('name', 'id')),
                Forms\Components\TextInput::make('name')
                    ->label('Name')
                    ->required(),
                Forms\Components\TextInput::make('email')
                    ->label('Email')
                    ->email()
                    ->unique(ignoreRecord: true)
                    // ->rules(['unique:customer_users,email'])
                    ->required(),
                Forms\Components\Select::make('gender')
                    ->options([
                        'male' => 'male',
                        'female' => 'female',
                        'other' => 'other',
                    ])
                    ->default('male')
                    ->required(),
                Forms\Components\TextInput::make('password')
                    ->password()
                    ->label('Password')
                    ->minLength(8)
                    // ->hiddenOn('edit')
                    ->same('passwordConfirmation')
                    ->required(fn(Page $livewire) => ($livewire instanceof CreateRecord))
                    ->dehydrated(fn($state) => filled($state))
                    ->dehydrateStateUsing(fn($state) => Hash::make($state)),
                Forms\Components\TextInput::make('passwordConfirmation')
                    ->password()
                    ->label('Password Confirmation')
                    ->minLength(8)
                    // ->hiddenOn('edit')
                    ->dehydrated(false)
                    ->required(fn(Page $livewire) => ($livewire instanceof CreateRecord)),
                Forms\Components\TextInput::make('phone')
                    ->label('Phone'),
                Forms\Components\Select::make('country_id')
                    ->relationship('country', 'name')
                    ->label('Select Country')
                    ->searchable(['name', 'iso2'])
                    ->live()
                    ->preload()
                    ->required(),
                Forms\Components\Select::make('state_id')
                    ->label('Select State')
                    ->options(fn(Get $get): Collection => State::query()
                        ->where('country_id', $get('country_id'))
                        ->pluck('name', 'id'))
                    ->live()
                    ->searchable(['name']),
                Forms\Components\Select::make('city_id')
                    ->label('Select City')
                    ->options(fn(Get $get): Collection => City::query()
                        ->where('country_id', $get('country_id'))
                        ->pluck('name', 'id'))
                    ->searchable(['name'])
                    ->live()
                    ->preload()
                    ->required(),
                Forms\Components\TextInput::make('postal_code')
                    ->label('Postal Code'),
                Forms\Components\Toggle::make('is_active')
                    ->label('Is Active')
                    ->onIcon('heroicon-m-bolt')
                    ->offIcon('heroicon-m-user')
                    ->onColor('success')
                    ->offColor('danger')
                    ->default(true),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('customer.name')
                    ->label('Customer Name')
                    ->searchable(),
                Tables\Columns\TextColumn::make('name')
                    ->label('Name')
                    ->searchable(),
                Tables\Columns\TextColumn::make('email')
                    ->label('Email')
                    ->searchable(),
                Tables\Columns\TextColumn::make('phone')
                    ->label('Phone')
                    ->searchable(),
                Tables\Columns\TextColumn::make('is_active')
                    ->label('Is Active'),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
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
            'index' => Pages\ListCustomerUsers::route('/'),
            'create' => Pages\CreateCustomerUser::route('/create'),
            'view' => Pages\ViewCustomerUser::route('/{record}'),
            'edit' => Pages\EditCustomerUser::route('/{record}/edit'),
        ];
    }
}
