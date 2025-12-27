<?php

namespace App\Filament\Resources\FlightResource\RelationManagers;

use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Facades\Config;

class SchedulesRelationManager extends RelationManager
{
    protected static string $relationship = 'schedules';

    public function form(Form $form): Form
    {
        $dayOptions = Config::get('constants.day');

        return $form
            ->schema([
                Forms\Components\Select::make('day')
                    ->options($dayOptions)
                    ->required()
                    ->label('Day'),
                Forms\Components\TimePicker::make('departure_time')
                    ->label('Departure Time'),
                Forms\Components\TimePicker::make('arrival_time')
                    ->label('Arrival Time'),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitle('day')
            ->columns([
                Tables\Columns\TextColumn::make('day')
                    ->formatStateUsing(function (string $state): string {
                    $day = constants("day.$state");
                    return __($day);
                })
                    ->searchable()
                    ->label('Day'),
                Tables\Columns\TextColumn::make('departure_time')
                    ->label('Departure Time'),
                Tables\Columns\TextColumn::make('arrival_time')
                    ->label('Arrival Time'),
            ])
            ->filters([
                //
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make(),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }
}
