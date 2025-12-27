<?php

namespace App\Filament\Resources;

use App\Filament\Resources\CurrencyResource\Pages;
use App\Filament\Resources\CurrencyResource\RelationManagers;
use App\Models\Currency;
use App\Models\Country;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class CurrencyResource extends Resource
{
    protected static ?string $model = Currency::class;

    protected static ?string $navigationIcon = 'heroicon-o-banknotes';

    protected static ?string $navigationGroup = 'System';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('country_id')
                    ->relationship('country','name')
                    ->searchable()
                    ->required()
                    ->label('Country'),
                Forms\Components\TextInput::make('unit_per_usd')
                    ->label('Unit/USD')
                    ->required(),
                Forms\Components\TextInput::make('usd_per_unit')
                    ->label('USD/Unit')
                    ->required(),
                Forms\Components\TextInput::make('symbol')
                    ->label('Symbol')
                    ->required(),
                Forms\Components\TextInput::make('name')
                    ->label('Name')
                    ->required(),
                Forms\Components\TextInput::make('symbol_native')
                    ->label('Symbol Native')
                    ->required(),
                Forms\Components\TextInput::make('decimal_mark')
                    ->label('Decimal Mark')
                    ->required(),
                Forms\Components\TextInput::make('code')
                    ->label('Code')
                    ->required(),

            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('country_name')
                    ->label('Country')
                    ->state(function ($record) {
                        return $record->country->name;
                    })
                    ->searchable(),
                Tables\Columns\TextColumn::make('name')
                    ->label('Name')
                    ->searchable(),
                Tables\Columns\TextColumn::make('unit_per_usd')
                    ->label('Unit/USD'),
                Tables\Columns\TextColumn::make('usd_per_unit')
                    ->label('USD/Unit'),
                Tables\Columns\TextColumn::make('symbol')
                    ->label('Symbol')
                    ->searchable(),
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
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListCurrencies::route('/'),
            'edit' => Pages\EditCurrency::route('/{record}/edit'),
        ];
    }
}
