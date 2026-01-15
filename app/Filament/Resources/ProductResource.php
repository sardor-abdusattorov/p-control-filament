<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ProductResource\Pages;
use App\Filament\Resources\ProductResource\RelationManagers;
use App\Models\Product;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class ProductResource extends Resource
{
    protected static ?string $model = Product::class;

    protected static ?string $navigationIcon = 'heroicon-o-cube';

    protected static ?string $navigationGroup = 'Товары';

    protected static ?int $navigationSort = 3;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Основная информация')
                    ->schema([
                        \AbdulMajeeds\FilamentTranslatableTabs\Forms\Components\TranslatableTabs::make()
                            ->schema([
                                Forms\Components\TextInput::make('name')
                                    ->label('Название товара')
                                    ->required()
                                    ->maxLength(255),

                                Forms\Components\RichEditor::make('description')
                                    ->label('Описание')
                                    ->columnSpanFull(),
                            ]),

                        Forms\Components\Select::make('brand_id')
                            ->label('Бренд')
                            ->relationship('brand', 'name')
                            ->searchable()
                            ->preload()
                            ->createOptionForm([
                                \AbdulMajeeds\FilamentTranslatableTabs\Forms\Components\TranslatableTabs::make()
                                    ->schema([
                                        Forms\Components\TextInput::make('name')
                                            ->label('Название бренда')
                                            ->required(),
                                    ]),
                            ]),

                        Forms\Components\Select::make('category_id')
                            ->label('Категория')
                            ->relationship('category', 'name')
                            ->searchable()
                            ->preload()
                            ->createOptionForm([
                                \AbdulMajeeds\FilamentTranslatableTabs\Forms\Components\TranslatableTabs::make()
                                    ->schema([
                                        Forms\Components\TextInput::make('name')
                                            ->label('Название категории')
                                            ->required(),
                                    ]),
                            ]),

                        \Awcodes\Curator\Components\Forms\CuratorPicker::make('image')
                            ->label('Изображение')
                            ->buttonLabel('Выбрать изображение')
                            ->color('primary'),
                    ])
                    ->columns(2),

                Forms\Components\Section::make('Цена и количество')
                    ->schema([
                        Forms\Components\TextInput::make('price')
                            ->label('Цена')
                            ->required()
                            ->numeric()
                            ->default(0)
                            ->minValue(0)
                            ->prefix('₽')
                            ->step(0.01),

                        Forms\Components\TextInput::make('quantity')
                            ->label('Количество')
                            ->required()
                            ->numeric()
                            ->default(0)
                            ->minValue(0)
                            ->step(0.01),

                        Forms\Components\TextInput::make('unit')
                            ->label('Единица измерения')
                            ->placeholder('шт, кг, л, м')
                            ->maxLength(50),

                        Forms\Components\Toggle::make('status')
                            ->label('В наличии')
                            ->default(true)
                            ->inline(false),
                    ])
                    ->columns(2),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('id')
                    ->label('ID')
                    ->sortable(),

                \Awcodes\Curator\Components\Tables\CuratorColumn::make('image')
                    ->label('Фото')
                    ->size(50),

                Tables\Columns\TextColumn::make('name')
                    ->label('Название')
                    ->searchable()
                    ->sortable()
                    ->limit(40),

                Tables\Columns\TextColumn::make('brand.name')
                    ->label('Бренд')
                    ->searchable()
                    ->sortable()
                    ->toggleable(),

                Tables\Columns\TextColumn::make('category.name')
                    ->label('Категория')
                    ->searchable()
                    ->sortable()
                    ->toggleable(),

                Tables\Columns\TextColumn::make('price')
                    ->label('Цена')
                    ->money('RUB')
                    ->sortable(),

                Tables\Columns\TextColumn::make('quantity')
                    ->label('Количество')
                    ->numeric(decimalPlaces: 2)
                    ->sortable()
                    ->toggleable(),

                Tables\Columns\TextColumn::make('unit')
                    ->label('Ед.')
                    ->toggleable(),

                Tables\Columns\IconColumn::make('status')
                    ->label('Статус')
                    ->boolean()
                    ->sortable(),

                Tables\Columns\TextColumn::make('created_at')
                    ->label('Создано')
                    ->dateTime('d-m-Y H:i')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                Tables\Filters\TernaryFilter::make('status')
                    ->label('Статус')
                    ->boolean()
                    ->trueLabel('В наличии')
                    ->falseLabel('Нет в наличии')
                    ->native(false),

                Tables\Filters\SelectFilter::make('brand_id')
                    ->label('Бренд')
                    ->relationship('brand', 'name')
                    ->searchable()
                    ->preload(),

                Tables\Filters\SelectFilter::make('category_id')
                    ->label('Категория')
                    ->relationship('category', 'name')
                    ->searchable()
                    ->preload(),
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ])
            ->defaultSort('id', 'desc');
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
            'view' => Pages\ViewProduct::route('/{record}'),
            'edit' => Pages\EditProduct::route('/{record}/edit'),
        ];
    }
}
