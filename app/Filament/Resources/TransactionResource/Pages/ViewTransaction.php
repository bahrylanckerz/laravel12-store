<?php

namespace App\Filament\Resources\TransactionResource\Pages;

use Filament\Infolists\Infolist;
use Filament\Forms\Components\Card;
use Filament\Forms\Components\Grid;
use Filament\Resources\Pages\viewRecord;
use Filament\Infolists\Components\TextEntry;
use Filament\Infolists\Components\ImageEntry;
use App\Filament\Resources\TransactionResource;
use Filament\Infolists\Components\RepeatableEntry;
use Filament\Infolists\Components\TextEntry\TextEntrySize;

class ViewTransaction extends viewRecord
{
    protected static string $resource = TransactionResource::class;

    public function infolist(Infolist $infolist): Infolist
    {
        return $infolist
            ->schema([
                Card::make()
                ->schema([
                    TextEntry::make('invoice')
                        ->label('Invoice ID'),
                    TextEntry::make('status')
                        ->label('Status')
                        ->badge()
                        ->color([
                            'pending' => 'warning',
                            'confirmed' => 'success',
                            'shipped' => 'primary',
                            'delivered' => 'indigo',
                            'canceled' => 'danger',
                            'expired' => 'gray',
                        ]),
                    TextEntry::make('created_at')
                        ->label('Order Date')
                        ->dateTime(),
                ])->columns(3),

                Card::make()
                ->schema([
                    TextEntry::make('customer.name')
                        ->label('Customer Name'),
                    TextEntry::make('customer.email')
                        ->label('Customer Email'),
                    TextEntry::make('address')
                        ->label('Customer Address'),
                ])->columns(3),

                Card::make()
                ->schema([
                    TextEntry::make('shipping.courier')
                        ->label('Shipping Carrier'),
                    TextEntry::make('shipping.service')
                        ->label('Shipping Service'),
                    TextEntry::make('shipping.cost')
                        ->label('Shipping Cost')
                        ->money('IDR', true),
                ])->columns(3),

                Card::make()
                ->schema([
                    RepeatableEntry::make('TransactionDetails')
                    ->label('Order Items')
                    ->schema([
                        ImageEntry::make('product.image')
                            ->label('Product Image')
                            ->image()
                            ->size(50),
                        TextEntry::make('product.name')
                            ->label('Product Name'),
                        TextEntry::make('qty')
                            ->label('Quantity'),
                        TextEntry::make('product.price')
                            ->label('Product Price')
                            ->money('IDR', true),
                    ])->columns(4),
                ]),

                Card::make()
                ->schema([
                    Grid::make()
                    ->schema([
                        TextEntry::make('total')
                            ->label('Total Amount')
                            ->money('IDR', true)
                            ->size(TextEntrySize::Large)
                            ->color('primrary')
                            ->alignEnd(),
                    ]),
                ]),
            ]);
    }
}
