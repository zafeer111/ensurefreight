<?php

namespace App\Filament\Resources;

use App\Filament\Resources\FlightResource\Pages;
use App\Filament\Resources\FlightResource\RelationManagers;
use App\Filament\Resources\FlightResource\RelationManagers\SchedulesRelationManager;
use App\Models\Airport;
use App\Models\Flight;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class FlightResource extends Resource
{
    protected static ?string $model = Flight::class;

    protected static ?string $navigationIcon = 'heroicon-o-globe-alt';

    protected static ?string $navigationGroup = 'Origins';

    public static function form(Form $form): Form
    {
        $airports = Airport::pluck('iata_code', 'id');

        return $form
            ->schema([
                Forms\Components\Select::make('carriers_id')
                    ->relationship('carrier', 'carrier_name')
                    ->searchable()
                    ->required()
                    ->label('Carrier'),
                Forms\Components\Select::make('departure_airport_code')
                    ->options($airports)
                    ->searchable()
                    ->required()
                    ->label('Departure Airport Code'),
                Forms\Components\Select::make('arrival_airport_code')
                    ->options($airports)
                    ->searchable()
                    ->required()
                    ->label('Arrival Airport Code'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('carrier.carrier_name')
                ->label('Carrier')
                ->searchable()
                ->sortable(),
                Tables\Columns\TextColumn::make('departure_airport_code')
                ->label('Departure Airport Code')
                ->searchable()
                ->sortable(),
                Tables\Columns\TextColumn::make('arrival_airport_code')
                ->label('Arrival Airport Code')
                ->searchable()
                ->sortable(),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
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
            SchedulesRelationManager::class,
        ];
    }
    
    public static function getPages(): array
    {
        return [
            'index' => Pages\ListFlights::route('/'),
            'create' => Pages\CreateFlight::route('/create'),
            'edit' => Pages\EditFlight::route('/{record}/edit'),
        ];
    }    
}
