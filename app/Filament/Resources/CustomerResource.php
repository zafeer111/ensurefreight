<?php

namespace App\Filament\Resources;

use App\Filament\Resources\CustomerResource\Pages;
use App\Filament\Resources\CustomerResource\RelationManagers;
use App\Models\Airport;
use App\Models\City;
use App\Models\Customer;
use App\Models\State;
use Filament\Forms;
use Filament\Forms\Components\{Card, Select, TextInput, Textarea};
use Filament\Forms\Get;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Illuminate\Support\Collection;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class CustomerResource extends Resource
{
    protected static ?string $model = Customer::class;

    protected static ?string $navigationIcon = 'heroicon-o-user-plus';
    protected static ?string $navigationGroup = 'Companies or Individuals';

    public static function form(Form $form): Form
    {
        return $form
        ->schema([
            Card::make()
                ->schema([
                    TextInput::make('name')
                        ->required()
                        ->maxLength(255),
                    Textarea::make('address')
                        ->required()
                        ->maxLength(255),
                    TextInput::make('email')
                        ->required()
                        ->email()
                        ->maxLength(100),
                    TextInput::make('postal_code')
                        ->label('Postal/Zip Code')
                        ->required()
                        ->maxLength(100),
                    Select::make('country_id')
                        ->relationship('country', 'name')
                        ->live()
                        ->preload()
                        ->searchable(['name', 'iso2'])
                        ->required(),
                    Select::make('state_id')
                        ->label('Select State')
                        ->options(fn (Get $get): Collection => State::query()
                            ->where('country_id', $get('country_id'))
                            ->pluck('name', 'id'))
                        ->searchable(['name'])
                        ->preload()
                        ->required(),
                    Select::make('city_id')
                        ->label('Select City')
                        ->options(fn (Get $get): Collection => City::query()
                            ->where('state_id', $get('state_id'))
                            ->where('country_id', $get('country_id'))
                            ->pluck('name', 'id'))
                        ->searchable(['name'])
                        ->preload()
                        ->required(),
                    Select::make('airport_id')
                        ->label('Select Airport')
                        ->options(fn (Get $get): Collection => Airport::query()
                            // ->where('country_id', $get('country_id'))
                            // ->where('state_id', $get('state_id'))
                            // ->where('city_id', $get('city_id'))
                            ->get()
                            ->pluck('iata_code', 'id'))
                        ->searchable(['iata_code'])
                        ->preload()
                        ->required(),
                ])->columnSpan(2),
            Card::make()
                ->schema([
                    Select::make('type')
                        ->label('Customer Type')
                        ->required()
                        ->options([
                            '0' => 'Company',
                            '1' => 'Individual',
                        ])
                        ->default(0),
                    TextInput::make('account_no')
                        ->required()
                        ->maxLength(30),
                    TextInput::make('contact_person')
                        ->label('Name of Contact Person')
                        ->maxLength(255),
                    TextInput::make('phone')
                        ->required()
                        ->maxLength(40),
                    TextInput::make('alternate_phone_no')
                        ->maxLength(40),
                    TextInput::make('fax')
                        ->maxLength(40),
                    TextInput::make('cell_no')
                        ->required()
                        ->maxLength(100),
                    TextInput::make('domain')
                        ->maxLength(255),
                ])->columnSpan(2),
        ])
        ->columns([
            'sm' => 4,
            'lg' => null,
        ]);
}

    public static function table(Table $table): Table
    {
        return $table
        ->columns([
            TextColumn::make('name')
                ->sortable()
                ->searchable(),
            Tables\Columns\TextColumn::make('type')
                ->formatStateUsing(fn (string $state): string => __($state == 0 ? "Company" : 'Individual'))
                ->sortable()
                ->searchable(),
            TextColumn::make('country.name')
                ->label('Country')
                ->sortable()
                ->searchable(),
            TextColumn::make('city.name')
                ->label('City')
                ->sortable()
                ->searchable(),
        ])
        ->filters([
            SelectFilter::make('type')
                ->options([
                    '0' => 'Company',
                    '1' => 'Individual',
                ]),
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
            'index' => Pages\ListCustomers::route('/'),
            'create' => Pages\CreateCustomer::route('/create'),
            'view' => Pages\ViewCustomer::route('/{record}'),
            'edit' => Pages\EditCustomer::route('/{record}/edit'),
        ];
    }    
}
