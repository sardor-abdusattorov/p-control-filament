<?php

namespace App\Filament\Resources;

use AbdulmajeedJamaan\FilamentTranslatableTabs\TranslatableTabs;
use App\Filament\Resources\TextBlockResource\Pages;
use App\Models\TextBlock;
use Awcodes\Curator\Components\Forms\CuratorPicker;
use Awcodes\Curator\Components\Tables\CuratorColumn;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class TextBlockResource extends Resource
{
    protected static ?string $model = TextBlock::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $navigationGroup = 'resources';

    protected static ?int $navigationSort = 9;

    public static function getNavigationGroup(): ?string
    {
        return __('app.label.resources');
    }

    public static function getModelLabel(): string
    {
        return __('app.label.text_block_single');
    }

    public static function getPluralModelLabel(): string
    {
        return __('app.label.text_block_plural');
    }

    public static function getNavigationBadge(): ?string
    {
        return (string) static::$model::count();
    }

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
                                Forms\Components\TextInput::make('name')
                                    ->label(__('app.label.system_name'))
                                    ->required()
                                    ->unique(ignoreRecord: true),

                                CuratorPicker::make('image')
                                    ->label(__('app.label.main_image')),

                                TranslatableTabs::make('translations')
                                    ->schema([
                                        Forms\Components\TextInput::make('title')
                                            ->label(__('app.label.title'))
                                            ->required(),

                                        Forms\Components\RichEditor::make('content')
                                            ->label(__('app.label.content')),

                                    ]),

                                Forms\Components\Toggle::make('status')
                                    ->label(__('app.label.status'))
                                    ->default(true),
                            ]),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                CuratorColumn::make('image')
                    ->label(__('app.label.image'))
                    ->size(56),

                Tables\Columns\TextColumn::make('name')
                    ->label(__('app.label.system_name'))
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('title')
                    ->label(__('app.label.title'))
                    ->sortable()
                    ->wrap()
                    ->searchable(),

                Tables\Columns\TextColumn::make('created_at')
                    ->label(__('app.label.created'))
                    ->dateTime('d.m.Y H:i')
                    ->sortable()
                    ->toggleable(),

                Tables\Columns\TextColumn::make('updated_at')
                    ->label(__('app.label.updated'))
                    ->dateTime('d.m.Y H:i')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),

                Tables\Columns\TextColumn::make('status')
                    ->label(__('app.label.status'))
                    ->formatStateUsing(fn ($state) => $state ? __('app.label.active') : __('app.label.inactive'))
                    ->badge()
                    ->sortable()
                    ->color(fn ($state) => $state ? 'success' : 'danger'),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('status')
                    ->label(__('app.label.status'))
                    ->options([
                        1 => __('app.label.active'),
                        0 => __('app.label.inactive'),
                    ]),
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

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListTextBlocks::route('/'),
            'create' => Pages\CreateTextBlock::route('/create'),
            'view' => Pages\ViewTextBlock::route('/{record}'),
            'edit' => Pages\EditTextBlock::route('/{record}/edit'),
        ];
    }
}
