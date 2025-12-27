<?php

namespace App\Filament\Resources\QuotationResource\RelationManagers;

use App\Models\Carrier;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Facades\Config;

class QuotationLineItemRelationManager extends RelationManager
{
    protected static string $relationship = 'quotationLineItems';

    public function form(Form $form): Form
    {
        $status = Config::get('constants.quotation_line_item_status');

        return $form
            ->schema([
                Forms\Components\Select::make('carrier_id')
                    ->options(Carrier::pluck('carrier_name', 'id'))
                    ->searchable()
                    ->label('Carrier Name')
                    ->required(),
                Forms\Components\TextInput::make('tariff_rate')
                    ->label('Tariff Rate (USD)')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('surcharge')
                    ->label('Surcharge (CAD)')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('airable_charge')
                    ->label('Airable Charge (CAD)')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('custom_charge')
                    ->label('Custom Charge (USD)')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('rate_per_kg')
                    ->label('Rate/KG (USD)')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('zero_profit_rate')
                    ->label('Without Profit Rate/KG (USD)')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('total_rate')
                    ->label('Total Rate (USD)')
                    ->required()
                    ->maxLength(255),
                Forms\Components\Select::make('status')
                    ->required()
                    ->options($status),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('carrier.carrier_name')
            ->columns([
                Tables\Columns\TextColumn::make('carrier.carrier_name')
                    ->label('Carrier Name')
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('tariff_rate')
                    ->label('Tariff Rate (USD)'),
                Tables\Columns\TextColumn::make('surcharge')
                    ->label('Surcharge (CAD)'),
                Tables\Columns\TextColumn::make('airable_charge')
                    ->label('Airable Charge (CAD)'),
                Tables\Columns\TextColumn::make('custom_charge')
                    ->label('Custom Charge (USD)'),
                Tables\Columns\TextColumn::make('rate_per_kg')
                    ->label('Rate/KG (USD)'),
                Tables\Columns\TextColumn::make('zero_profit_rate')
                    ->label('Without Profit Rate/KG (USD)'),
                Tables\Columns\TextColumn::make('total_rate')
                    ->label('Total Rate (USD)'),
                Tables\Columns\TextColumn::make('status')
                    ->label('Status')
                    ->sortable()
                    ->searchable()
                    ->formatStateUsing(function (string $state): string {
                        $status = constants("quotation_line_item_status.$state");
                        return __($status);
                    }),
            ])
            ->filters([
                Tables\Filters\Filter::make('carrier.carrier_name')
                    ->label('Carrier Name'),
                Tables\Filters\Filter::make('status')
                    ->label('Status'),
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
