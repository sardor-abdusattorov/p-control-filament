<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ContactSubcategoryResource\Pages;
use App\Filament\Resources\ContactSubcategoryResource\RelationManagers;
use App\Models\ContactSubcategory;
use App\Models\ContactCategory;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Abdulmajeed\FilamentTranslatableTabs\Forms\TranslatableTabs;

class ContactSubcategoryResource extends Resource
{
    protected static ?string $model = ContactSubcategory::class;

    protected static ?string $navigationIcon = 'heroicon-o-folder';

    public static function getNavigationGroup(): ?string
    {
        return __('app.label.contacts');
    }

    protected static ?int $navigationSort = 2;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make()
                    ->schema([
                        Forms\Components\Select::make('category_id')
                            ->label('Category')
                            ->relationship('category', 'title')
                            ->searchable()
                            ->preload()
                            ->required()
                            ->createOptionForm([
                                TranslatableTabs::make()
                                    ->locales(['en', 'ru', 'uz'])
                                    ->defaultLocale('en')
                                    ->columnSpanFull()
                                    ->schema([
                                        Forms\Components\TextInput::make('title')
                                            ->required()
                                            ->maxLength(500),
                                        Forms\Components\Textarea::make('info')
                                            ->rows(3),
                                    ]),
                                Forms\Components\Toggle::make('status')
                                    ->label('Active')
                                    ->default(true),
                            ]),
                        TranslatableTabs::make()
                            ->locales(['en', 'ru', 'uz'])
                            ->defaultLocale('en')
                            ->columnSpanFull()
                            ->schema([
                                Forms\Components\TextInput::make('title')
                                    ->required()
                                    ->maxLength(500)
                                    ->columnSpanFull(),
                                Forms\Components\Textarea::make('info')
                                    ->rows(3)
                                    ->columnSpanFull(),
                            ]),
                        Forms\Components\Toggle::make('status')
                            ->label('Active')
                            ->default(true)
                            ->inline(false),
                    ])
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('id')
                    ->label('ID')
                    ->sortable(),
                Tables\Columns\TextColumn::make('category.title')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('title')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('contacts_count')
                    ->counts('contacts')
                    ->label('Contacts'),
                Tables\Columns\IconColumn::make('status')
                    ->boolean()
                    ->sortable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime('d-m-Y H:i')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('category_id')
                    ->label('Category')
                    ->relationship('category', 'title')
                    ->searchable()
                    ->preload(),
                Tables\Filters\TernaryFilter::make('status')
                    ->label('Status')
                    ->placeholder('All')
                    ->trueLabel('Active')
                    ->falseLabel('Inactive'),
            ])
            ->actions([
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
            'index' => Pages\ListContactSubcategories::route('/'),
            'create' => Pages\CreateContactSubcategory::route('/create'),
            'edit' => Pages\EditContactSubcategory::route('/{record}/edit'),
        ];
    }
}
