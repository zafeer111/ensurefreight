<?php

namespace App\Filament\Resources;

use App\Filament\Resources\BookingResource\Pages;
use App\Filament\Resources\BookingResource\RelationManagers;
use App\Models\Booking;
use App\Models\Carrier;
use App\Models\CustomerUser;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Facades\Config;

class BookingResource extends Resource
{
    protected static ?string $model = Booking::class;

    protected static ?string $navigationIcon = 'heroicon-o-clipboard-document-check';

    protected static ?string $navigationGroup = 'Bookings & Quotations';

    public static function form(Form $form): Form
    {
        $status = Config::get('constants.booking_status');

        return $form
            ->schema([
                Forms\Components\TextInput::make('quotation_id')
                    ->required(),
                Forms\Components\Select::make('customer_user_id')
                    ->required()
                    ->searchable()
                    ->options(CustomerUser::pluck('name', 'id')),
                Forms\Components\Select::make('carrier_id')
                    ->required()
                    ->searchable()
                    ->options(Carrier::pluck('carrier_name', 'id')),
                Forms\Components\TextInput::make('tariff_rate')
                    ->label('Tariff Rate (USD)')
                    ->required(),
                Forms\Components\TextInput::make('surcharge')
                    ->label('Surcharge (CAD)')
                    ->required(),
                Forms\Components\TextInput::make('airable_charge')
                    ->required()
                    ->label('Airable Charge (CAD)'),
                Forms\Components\TextInput::make('custom_charge')
                    ->label('Custom Charge (USD)')
                    ->required(),
                Forms\Components\TextInput::make('rate_per_kg')
                    ->required()
                    ->label('Rate/KG (USD)'),
                Forms\Components\TextInput::make('total_rate')
                    ->label('Total Rate (USD)')
                    ->required(),
                Forms\Components\Select::make('status')
                    ->required()
                    ->options($status),

            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('quotation_id')
                    ->label('Quotation')
                    ->sortable()
                    ->searchable()
                    ->url(fn ($record): string => QuotationResource::getUrl('view', ['record' => $record->quotation_id]))
                    ->state(function ($record) {
                        return $record->quotation_id === 'huhuhush4555' ? $record->quotation_id : 'View Quotation';
                    }),
                Tables\Columns\TextColumn::make('customerUser.name')
                    ->label('Customer User Name')
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('carrier.carrier_name')
                    ->label('Carrier Name')
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('tariff_rate')
                    ->label('Tariff Rate (USD)')
                    ->sortable()
                    ->searchable(),
//                Tables\Columns\TextColumn::make('surcharge')
//                    ->label('Surcharge (CAD)')
//                    ->sortable()
//                    ->searchable(),
//                Tables\Columns\TextColumn::make('airable_charge')
//                    ->label('Airable Charge (CAD)')
//                    ->sortable()
//                    ->searchable(),
//                Tables\Columns\TextColumn::make('custom_charge')
//                    ->label('Custom Charge (USD)')
//                    ->sortable()
//                    ->searchable(),
                Tables\Columns\TextColumn::make('rate_per_kg')
                    ->label('Rate/KG (USD)')
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('total_rate')
                    ->label('Total Rate (USD)')
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('status')
                    ->label('Status')
                    ->sortable()
                    ->searchable()
                    ->formatStateUsing(function (string $state): string {
                        $booking_status = constants("booking_status.$state");
                        return __($booking_status);
                    })
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        '0' => 'gray',
                        '1' => 'success',
                        '2' => 'warning',
                        '3' => 'danger',
                        default => 'gray',
                    }),

            ])
            ->filters([
                Tables\Filters\Filter::make('carrier.carrier_name')
                    ->label('Carrier Name'),
                Tables\Filters\Filter::make('customerUser.name')
                    ->label('Customer User Name'),
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
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListBookings::route('/'),
            'create' => Pages\CreateBooking::route('/create'),
            'edit' => Pages\EditBooking::route('/{record}/edit'),
            'view' => Pages\ViewBooking::route('/{record}')
        ];
    }
}
