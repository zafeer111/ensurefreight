<?php

namespace App\Filament\Widgets;

use App\Filament\Resources\InquiryResource\Pages;
use Filament\Forms\Components;
use App\Filament\Resources\InquiryResource;
use Filament\Tables\Actions\ActionGroup;
use Filament\Tables\Actions\ViewAction;
use Filament\Tables;
use Filament\Tables\Columns;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;
use Illuminate\Database\Eloquent\Builder;
use Chiiya\FilamentAccessControl\Traits\AuthorizesPageAccess;


class Inquiry extends BaseWidget
{
    use AuthorizesPageAccess;

    public static string $permission = ('widget.inquiry.view');

    public function mount(): void
    {
        static::authorizePageAccess();
    }

    protected static ?string $model = Inquiry::class;
    protected static ?int $sort = 4;
    

    public function table(Table $table): Table
    {
        return $table
            ->query(
                InquiryResource::getEloquentQuery()
            )
            ->defaultPaginationPageOption(5)
            ->defaultSort('created_at', 'desc')

            ->columns([
                Tables\Columns\TextColumn::make('customerUser.customer.name')
                    ->wrap()
                    ->words(2)
                    ->label('Company Name')
                    ->searchable(),
                Tables\Columns\TextColumn::make('commodity')
                    ->wrap()
                    ->words(2)
                    ->label('Commodity')
                    ->searchable(),
                Tables\Columns\TextColumn::make('quotation.from')
                    ->label('Origin')
                    ->wrap()
                    ->searchable(),
                Tables\Columns\TextColumn::make('quotation.to')
                    ->label('Dest')
                    ->wrap()
                    ->searchable(),
                Tables\Columns\TextColumn::make('status')
                    ->badge()
                    ->wrap()
                    ->icons([
                        'heroicon-m-bell',
                        'heroicon-o-clock' => 'Viewed',
                        'heroicon-o-check-circle' => 'Answered',
                        'heroicon-o-x-mark' => 'Rejected',
                        'heroicon-o-shield-exclamation' => 'Exception',
                    ])
                    ->color(fn (string $state): string => match ($state) {
                        'Initiate' => 'gray',
                        'Viewed'   => 'warning',
                        'Answered' => 'success',
                        'Rejected' => 'danger',
                        'Exception' => 'danger',
                        default => 'gray',
                    }),
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Created At')
                    ->wrap()
                    ->sortable(),
            ])
            ->actions([
                ActionGroup::make([
                    Tables\Actions\ViewAction::make()
                        ->url(fn ($record): string => InquiryResource::getUrl('view', ['record' => $record->id]))
                ])
                    ->tooltip('Actions'),
            ]);
    }
    public static function getPages(): array
    {
        return [
            'view' => Pages\ViewInquiry::route('/{record}'),
        ];
    }
}
