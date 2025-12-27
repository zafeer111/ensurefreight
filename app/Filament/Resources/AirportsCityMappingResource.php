<?php

namespace App\Filament\Resources;

use App\Filament\Resources\AirportsCityMappingResource\Pages;
use App\Filament\Resources\AirportsCityMappingResource\RelationManagers;
use App\Models\Airport;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Model;

class AirportsCityMappingResource extends Resource
{
    protected static ?string $model = Airport::class;

    protected static ?string $navigationIcon = 'heroicon-o-map-pin';
    protected static ?string $label = 'Airports Mapping';
    protected static ?string $navigationGroup = 'Origins';

    public static function form(Form $form): Form
    {
        return
            $form
            ->schema([
                Forms\Components\TextInput::make('iata_code')
                    ->label('IATA Code')
                    ->required()
                    ->maxLength(3)
                    ->required()
                ->disabled(),
                Forms\Components\Select::make('city')
                    ->label('Select City')
                    ->multiple()
                    ->relationship('airportCity','name',)
                    ->getOptionLabelFromRecordUsing(fn (Model $record) => "{$record->name} ({$record->state->name}, {$record->country->iso2})")

            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('iata_code')
                    ->label('Airport IATA Code')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('airport_city_count')
                    ->counts('airportCity')
                    ->label('Mapped Cities count')
                    ->sortable(),

            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->defaultSort('airport_city_count','DESC');

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
            'index' => Pages\ListAirportsCityMappings::route('/'),
            'edit' => Pages\EditAirportsCityMapping::route('/{record}/edit'),
        ];
    }
    public static function canCreate(): bool
    {
        return false;
    }


}
