<?php

namespace App\Filament\Resources;

use App\Filament\Resources\SiteTranslationsResource\Pages;
use App\Models\SiteTranslation;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class SiteTranslationsResource extends Resource
{
    protected static ?string $model = SiteTranslation::class;

    protected static ?string $navigationGroup = 'settings';

    protected static ?int $navigationSort = 2;

    public static function getNavigationGroup(): ?string
    {
        return __('app.label.settings');
    }

    public static function getModelLabel(): string
    {
        return __('app.label.site_translation_single');
    }

    public static function getPluralModelLabel(): string
    {
        return __('app.label.site_translation_plural');
    }


    public static function getNavigationBadge(): ?string
    {
        return (string) static::$model::count();
    }

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Grid::make()
                    ->columns(1)
                    ->schema([
                        Forms\Components\Section::make()
                            ->columnSpan(1)
                            ->schema([
                                Forms\Components\Hidden::make('category')
                                    ->default('app'),
                                Forms\Components\TextInput::make('key')
                                    ->label(__('app.label.key'))
                                    ->required()
                                    ->helperText(__('app.helper.key')),

                                Forms\Components\Textarea::make('value')
                                    ->label(__('app.label.value'))
                                    ->required()
                                    ->rows(6)
                                    ->helperText(__('app.helper.value'))
                                    ->translatableTabs(),
                            ]),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('category')
                    ->label(__('app.label.category'))
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('key')
                    ->label(__('app.label.key'))
                    ->searchable()
                    ->wrap()
                    ->sortable(),

                Tables\Columns\TextColumn::make('value')
                    ->label(__('app.label.value'))
                    ->sortable()
                    ->wrap()
                    ->searchable(),

                Tables\Columns\TextColumn::make('created_at')
                    ->label(__('app.label.created'))
                    ->dateTime('d.m.Y H:i')
                    ->toggleable(),

                Tables\Columns\TextColumn::make('updated_at')
                    ->label(__('app.label.updated'))
                    ->dateTime('d.m.Y H:i')
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
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
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListSiteTranslations::route('/'),
            'create' => Pages\CreateSiteTranslations::route('/create'),
            'edit' => Pages\EditSiteTranslations::route('/{record}/edit'),
            'view' => Pages\ViewSiteTranslation::route('/{record}'),
        ];
    }
}
