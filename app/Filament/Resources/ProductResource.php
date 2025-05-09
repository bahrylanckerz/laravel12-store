<?php

namespace App\Filament\Resources;

use Filament\Tables;
use App\Models\Product;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Filament\Resources\Resource;
use Filament\Forms\Components\Card;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\RichEditor;
use App\Filament\Resources\ProductResource\Pages;
use Filament\Forms\Components\Select;

class ProductResource extends Resource
{
    protected static ?string $model = Product::class;

    protected static ?string $navigationIcon = 'heroicon-o-shopping-bag';

    protected static ?string $navigationGroup = 'Master Data';

    protected static ?int $navigationSort = 2;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Card::make()
                    ->schema([
                        TextInput::make('name')
                            ->label('Product Name')
                            ->placeholder('Enter product name')
                            ->required(),
                        Select::make('category_id')
                            ->label('Category')
                            ->relationship('category', 'name')
                            ->required(),
                        RichEditor::make('description')
                            ->label('Product Description')
                            ->placeholder('Enter product description')
                            ->required(),
                        TextInput::make('weight')
                            ->label('Product Weight')
                            ->placeholder('Enter product weight')
                            ->numeric()
                            ->required(),
                        TextInput::make('price')
                            ->label('Product Price')
                            ->placeholder('Enter product price')
                            ->numeric()
                            ->required(),
                        FileUpload::make('image')
                            ->label('Product Image')
                            ->placeholder('Upload product image')
                            ->image()
                            ->required(),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\ImageColumn::make('image')
                    ->label('Image')
                    ->size(50),
                Tables\Columns\TextColumn::make('name')
                    ->label('Product Name')
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('category.name')
                    ->label('Category')
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('weight')
                    ->label('Weight'),
                Tables\Columns\TextColumn::make('price')
                    ->label('Price')
                    ->numeric(decimalPlaces: 0)
                    ->money('IDR', true),
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
            'index' => Pages\ListProducts::route('/'),
            'create' => Pages\CreateProduct::route('/create'),
            'edit' => Pages\EditProduct::route('/{record}/edit'),
        ];
    }
}
