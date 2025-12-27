<?php

namespace App\Filament\Resources;

use App\Filament\Resources\CarrierResource\Pages;
use App\Filament\Resources\CarrierResource\RelationManagers;
use App\Models\Carrier;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Facades\Config;

class CarrierResource extends Resource
{
    protected static ?string $model = Carrier::class;

    protected static ?string $navigationIcon = 'heroicon-o-shopping-cart';

    protected static ?string $navigationGroup = 'Miscellaneous';

    public static function form(Form $form): Form
    {
        $airlineType = Config::get('constants.airline_type');
        $airlineStatus = Config::get('constants.airline_status');

        return $form
            ->schema([
                Forms\Components\TextInput::make('carrier_code')
                    ->label('Carrier Code')
                    // ->required()
                    ->maxLength(20),
                Forms\Components\TextInput::make('carrier')
                    ->label('Carrier')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('carrier_name')
                    ->label('Carrier Name')
                    ->required()
                    ->maxLength(255),
                Forms\Components\Select::make('type')
                ->label('Type')
                ->options($airlineType)
                ->default(1),
                Forms\Components\Select::make('status')
                    ->label('Status')
                    ->options($airlineStatus)
                    ->default(0),
                Forms\Components\FileUpload::make('logo')
                    ->label('Logo')
                    ->image()
                    //enableOpen is deprecated so i use openable
                    ->openable()
                    ->maxSize(2 * 1024)
                    ->acceptedFileTypes(['image/jpeg', 'image/jpg']),
            ]);
    }

    public static function table(Table $table): Table
    {
        $airlineType = Config::get('constants.airline_type');
        $airlineStatus = Config::get('constants.airline_status');
        
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('carrier_name')
                    ->label('Carrier Name')
                    ->searchable(),
                Tables\Columns\TextColumn::make('carrier')
                    ->label('Carrier')
                    ->searchable(),
                Tables\Columns\TextColumn::make('carrier_code')
                    ->label('Carrier Code')
                    ->searchable(),
                Tables\Columns\TextColumn::make('type')
                    ->label('Type')
                    ->searchable()
                    ->formatStateUsing(function (string $state): string {
                        return $state;
                    })
                    ->searchable(),
                Tables\Columns\TextColumn::make('status')
                    ->label('Status')
                    ->searchable()
                    ->formatStateUsing(function (string $state): string {
                        return $state;
                    }),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('type')
                ->placeholder('Filter by Type')
                ->options($airlineType),
            Tables\Filters\SelectFilter::make('status')
                ->placeholder('Filter by Status')
                ->options($airlineStatus),
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
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListCarriers::route('/'),
            'create' => Pages\CreateCarrier::route('/create'),
            'edit' => Pages\EditCarrier::route('/{record}/edit'),
        ];
    }
}
