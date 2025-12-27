<?php

namespace App\Filament\Resources;

use App\Filament\Resources\QuotationResource\Pages;
use App\Filament\Resources\QuotationResource\RelationManagers;
use App\Models\Airport;
use App\Models\Inquiry;
use App\Models\Quotation;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Facades\Config;

class QuotationResource extends Resource
{
    protected static ?string $model = Quotation::class;

    protected static ?string $navigationIcon = 'heroicon-o-clipboard-document-list';

    protected static ?string $navigationGroup = 'Bookings & Quotations';


    public static function form(Form $form): Form
    {
        $cargoTypes = Config::get('constants.cargo_type');

        return $form
            ->schema([
                    Forms\Components\TextInput::make('inquiry_id')
                    ->hiddenOn('view')
                    ->required(),
                    Forms\Components\Select::make('from')
                        ->label('From (Origin)')
                        ->required()
                        ->searchable()
                        ->options(Airport::pluck('iata_code', 'id')),
                    Forms\Components\Select::make('to')
                        ->label('To (Destination)')
                        ->required()
                        ->searchable()
                        ->options(Airport::pluck('iata_code', 'id')),
                    Forms\Components\TextInput::make('weight')
                        ->required(),
                    Forms\Components\TextInput::make('profit')
                        ->label('Profit (USD)')
                        ->required(),
                    Forms\Components\TextInput::make('pickup_charge')
                        ->label('Pickup Charge (CAD)')
                        ->required(),
                    Forms\Components\TextInput::make('pickup_carrier_name')
                        ->label('Pickup Carrier Name')
                        ->required(),
                    Forms\Components\TextInput::make('bonded_charge')
                        ->label('Bonded Charge (CAD)')
                        ->required(),
                    Forms\Components\Select::make('cargo_type')
                        ->required()
                        ->options($cargoTypes),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('referenceNo.reference_no')
                    ->label('Inquiry')
                    ->sortable()
                    ->searchable()
                    ->url(fn ($record): string => InquiryResource::getUrl('view', ['record' => $record->inquiry_id]))
                    ->state(function ($record) {
                        return $record->referenceNo->reference_no;
                    }),

                Tables\Columns\TextColumn::make('weight')
                    ->label('Weight(KG)')
                    ->sortable(),

                Tables\Columns\TextColumn::make('profit')
                    ->label('Profit (USD)')
                    ->sortable(),
//
//                Tables\Columns\TextColumn::make('pickup_charge')
//                    ->label('Pickup Charge (CAD)')
//                    ->sortable(),
//
//                Tables\Columns\TextColumn::make('bonded_charge')
//                    ->label('Bonded Charge (CAD)')
//                    ->sortable(),

                Tables\Columns\TextColumn::make('cargo_type')
                    ->label('Cargo Type')
                    ->formatStateUsing(function (string $state): string {
                        $cargo_type = constants("cargo_type.$state");
                        return __($cargo_type);
                    })
                    ->sortable(),
            ])
            ->filters([
                Tables\Filters\Filter::make('weight')
                    ->label('Weight (KG)'),
                Tables\Filters\Filter::make('profit')
                    ->label('Profit (USD)'),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\ViewAction::make(),
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
            RelationManagers\QuotationLineItemRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListQuotations::route('/'),
            'create' => Pages\CreateQuotation::route('/create'),
            'edit' => Pages\EditQuotation::route('/{record}/edit'),
            'view' => Pages\ViewQuotation::route('/{record}'),
        ];
    }
}
