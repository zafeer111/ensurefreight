<?php

namespace App\Filament\Resources;

use App\Filament\Resources\InquiryResource\Pages;
use App\Filament\Resources\InquiryResource\RelationManagers;
use App\Models\Airport;
use App\Models\ExceptionInquiry;
use App\Models\Inquiry;
use Carbon\Carbon;
use Filament\Forms;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Actions\ActionGroup;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Infolists;
use Filament\Infolists\Infolist;
use Filament\Infolists\Components\Section;
use Filament\Infolists\Components\Tabs;
use Filament\Infolists\Components\TextEntry;
use Filament\Tables\Columns\Column;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Filters\MultiSelectFilter;
use Filament\Tables\Filters\SelectFilter;
use Illuminate\Support\Facades\Config;

class InquiryResource extends Resource
{
    protected static ?string $model = Inquiry::class;

    protected static ?string $navigationIcon = 'heroicon-o-document-magnifying-glass';
    protected static ?string $navigationGroup = 'Inquiry';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                //
            ]);
    }

    public static function table(Table $table): Table
    {
        $inquiryStatus = Config::get('constants.status');

        return $table
            ->columns([
            Tables\Columns\TextColumn::make('referenceNo.reference_no')
                ->label('Reference No')
                ->searchable(),
            Tables\Columns\TextColumn::make('commodity')
                ->label('Commodity')
                ->wrap()
                ->searchable(),
            Tables\Columns\TextColumn::make('mode')
                ->formatStateUsing(function (string $state): string {
                    $mode = constants("mode.$state");
                    return __($mode);
                })
                ->label('Mode')
                ->searchable(),
            Tables\Columns\TextColumn::make('customerUser.name')
                ->label('Customer Name')
                ->wrap()
                ->url(fn ($record): string => CustomerUserResource::getUrl('view', ['record' => $record->customerUser->customer_user_uuid]))
                ->searchable(),
            Tables\Columns\TextColumn::make('customerUser.customer.name')
                ->label('Company Name')
                ->wrap()
                ->searchable(),
            Tables\Columns\TextColumn::make('quotation.from')
                ->label('Origin')
                ->wrap()
                ->searchable(),
            Tables\Columns\TextColumn::make('quotation.to')
                ->label('Dest')
                ->wrap()
                ->searchable(),
            Tables\Columns\TextColumn::make('quotation.weight')
                ->label('Total Weight')
                ->wrap()
                ->searchable(),
            Tables\Columns\TextColumn::make('created_at')
                ->label('Created At')
                ->wrap()
                ->searchable(),
            Tables\Columns\TextColumn::make('status')
                ->badge()
                ->sortable()
                ->icons([
                    'heroicon-m-bell',
                    'heroicon-o-clock' => 'Viewed',
                    'heroicon-o-check-circle' => 'Answered',
                    'heroicon-o-x-mark' => 'Rejected',
                    'heroicon-o-shield-exclamation' => 'Exception',
                ])
                ->color(fn (string $state): string => match ($state) {
                'Initiate' => 'gray',
                'Viewed' => 'warning',
                'Answered' => 'success',
                'Rejected' => 'danger',
                'Exception' => 'danger',
                default => 'gray',
            })
            ])->defaultSort('created_at', 'desc')
            ->filters([
                Tables\Filters\SelectFilter::make('status')
                ->label('Filter by status')
                    ->options($inquiryStatus),

                Filter::make('created_at')
                ->form([
                    DatePicker::make('created_from'),
                    DatePicker::make('created_until')
                    ->default(now()),
                ])
                ->query(function (Builder $query, array $data): Builder {
                    return $query
                        ->when(
                            $data['created_from'],
                            fn (Builder $query, $date): Builder => $query->whereDate('created_at', '>=', $date),
                        )
                        ->when(
                            $data['created_until'],
                            fn (Builder $query, $date): Builder => $query->whereDate('created_at', '<=', $date),
                        );
                })
            ])

            ->actions([
                ActionGroup::make([
                    Tables\Actions\ViewAction::make(),
                ])
                ->tooltip('Actions'),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function infolist(Infolist $infolist): Infolist
    {
        return $infolist
        ->schema([
            Tabs::make('Label')
            ->columnSpan('full')
                ->tabs([
                    Tabs\Tab::make('Classification')
                        ->icon('heroicon-o-book-open')
                        ->schema([
                            Infolists\Components\TextEntry::make('commodity'),
                            Infolists\Components\TextEntry::make('incoterms'),
                            Infolists\Components\TextEntry::make('cargo_type')
                            ->formatStateUsing(function (string $state): string {
                                $cargo_type = constants("cargo_type.$state");
                                return __($cargo_type);
                            }),
                            Infolists\Components\TextEntry::make('mode')
                            ->formatStateUsing(function (string $state): string {
                                $mode = constants("mode.$state");
                                return __($mode);
                            })
                                ->columns(3)
                                ->markdown(),
                            Infolists\Components\TextEntry::make('pickup_date'),
                        ]),
                    Tabs\Tab::make('Pickup Address')
                        ->icon('heroicon-o-map-pin')
                        ->schema([
                            Infolists\Components\TextEntry::make('pickupAddress.contact_name')
                            ->label('Contact Name'),
                            Infolists\Components\TextEntry::make('pickupAddress.contact_email')
                            ->label("Contact Email"),
                            Infolists\Components\TextEntry::make('pickupAddress.postal_code')
                            ->label("Postal Code"),
                            Infolists\Components\TextEntry::make('pickupAddress.address')
                            ->label("Supplier's pickup address"),
                            Infolists\Components\TextEntry::make('pickupAddress.country.name')
                            ->label('Country Name'),
                            Infolists\Components\TextEntry::make('pickupAddress.state.name')
                            ->label('State Name'),
                            Infolists\Components\TextEntry::make('pickupAddress.city.name')
                            ->label('City Name'),
                        ]),
                    Tabs\Tab::make('Delivery Address')
                        ->icon('heroicon-o-truck')
                        ->schema([
                            Infolists\Components\TextEntry::make('deliveryAddress.postal_code')
                            ->label("Postal Code"),
                            Infolists\Components\TextEntry::make('dest_iata')->label('Destination Iata Code')
                        ]),
                        Tabs\Tab::make('Measurements')
                        ->icon('heroicon-o-bookmark')
                        ->schema([
                            Infolists\Components\TextEntry::make('measurements.quantity')
                            ->label('Quantity')
                            ->listWithLineBreaks(),
                            Infolists\Components\TextEntry::make('measurements.length')
                            ->label('Length')
                            ->listWithLineBreaks(),
                            Infolists\Components\TextEntry::make('measurements.width')
                            ->label('Width')
                            ->listWithLineBreaks(),
                            Infolists\Components\TextEntry::make('measurements.height')
                            ->label('Height')
                            ->listWithLineBreaks(),
                            Infolists\Components\TextEntry::make('measurements.dimension_unit')
                            ->formatStateUsing(function (string $state): string {
                                $dimensionUnit = constants("dimension_unit.$state");
                                return __($dimensionUnit);
                            })
                            ->label('Dimension Unit')
                            ->listWithLineBreaks(),
                            Infolists\Components\TextEntry::make('measurements.weight')
                            ->label('Weight')
                            ->listWithLineBreaks(),
                            Infolists\Components\TextEntry::make('measurements.weight_unit')
                            ->formatStateUsing(function (string $state): string {
                                $weightUnit = constants("weight_unit.$state");
                                return __($weightUnit);
                            })
                            ->label('Weight Unit')
                            ->listWithLineBreaks(),
                        ])->columns(7),
                        Tabs\Tab::make('Broker Company')
                        ->icon('heroicon-o-building-library')
                        ->schema([
                            Infolists\Components\TextEntry::make('brokerDetail.company_name')
                            ->label('Broker Company'),
                            Infolists\Components\TextEntry::make('brokerDetail.contact_name')
                            ->label('Contact Name'),
                            Infolists\Components\TextEntry::make('brokerDetail.phone')
                            ->label('Phone'),
                            Infolists\Components\TextEntry::make('brokerDetail.email')
                            ->label('Email Address')
                            ->markdown(),
                        ]),
                        Tabs\Tab::make('Other Details')
                        ->icon('heroicon-o-cog')
                        ->schema([
                            Infolists\Components\TextEntry::make('priority')->label('Priority')
                            ->formatStateUsing(function (string $state): string {
                                $priority = constants("priority.$state");
                                return __($priority);
                            }),
                            Infolists\Components\TextEntry::make('pickup_reference')->label('Pickup Reference'),
                            Infolists\Components\TextEntry::make('notes')->label('Notes'),
                            Infolists\Components\TextEntry::make('user_reference_number')->label('Inquiry Reference Number')
                        ]),
                ])->columns(2),

                Section::make()
                ->schema([
                    TextEntry::make('exceptionInquiry.exception_message')
                        ->label('Exception Message'),
                    TextEntry::make('exceptionInquiry.status')
                        ->label('Status')
                        ->badge()
                        ->color(fn (string $state): string => match ($state) {
                            '1' => 'success', // Active
                            '2' => 'danger', // Resolved
                            default => 'gray',
                        })
                        ->formatStateUsing(function (string $state): string {
                            $status = constants("exception_status.$state");
                            return __($status);
                        }),
                ])
                ->columns(1),
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
            'index' => Pages\ListInquiries::route('/'),
           'create' => Pages\CreateInquiry::route('/create'),
            'view' => Pages\ViewInquiry::route('/{record}'),
            'edit' => Pages\EditInquiry::route('/{record}/edit'),
        ];
    }
}
