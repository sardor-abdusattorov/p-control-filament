<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ProjectResource\Pages;
use App\Filament\Resources\ProjectResource\RelationManagers;
use App\Models\Project;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class ProjectResource extends Resource
{
    protected static ?string $model = Project::class;

    protected static ?string $navigationIcon = 'heroicon-o-briefcase';

    protected static ?string $navigationGroup = 'Projects & Contracts';

    protected static ?int $navigationSort = 1;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make()
                    ->schema([
                        Forms\Components\Grid::make(2)
                            ->schema([
                                Forms\Components\TextInput::make('project_number')
                                    ->maxLength(255),
                                Forms\Components\TextInput::make('title')
                                    ->required()
                                    ->maxLength(500)
                                    ->columnSpanFull(),
                            ]),
                        Forms\Components\Grid::make(3)
                            ->schema([
                                Forms\Components\TextInput::make('budget_sum')
                                    ->numeric()
                                    ->prefix('$')
                                    ->maxValue(99999999999999.99),
                                Forms\Components\Select::make('currency_id')
                                    ->label('Currency')
                                    ->relationship('currency', 'short_name')
                                    ->searchable()
                                    ->preload(),
                                Forms\Components\Select::make('status')
                                    ->options(Project::getStatuses())
                                    ->required()
                                    ->default(Project::STATUS_NEW),
                            ]),
                        Forms\Components\Grid::make(3)
                            ->schema([
                                Forms\Components\DatePicker::make('project_year')
                                    ->required()
                                    ->displayFormat('Y')
                                    ->format('Y-m-d'),
                                Forms\Components\DatePicker::make('deadline')
                                    ->required(),
                                Forms\Components\Select::make('user_id')
                                    ->label('Responsible User')
                                    ->relationship('user', 'name')
                                    ->searchable()
                                    ->preload()
                                    ->required(),
                            ]),
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
                Tables\Columns\TextColumn::make('project_number')
                    ->searchable()
                    ->sortable()
                    ->toggleable(),
                Tables\Columns\TextColumn::make('title')
                    ->searchable()
                    ->sortable()
                    ->limit(50),
                Tables\Columns\TextColumn::make('budget_sum')
                    ->money()
                    ->sortable(),
                Tables\Columns\TextColumn::make('currency.short_name')
                    ->sortable()
                    ->toggleable(),
                Tables\Columns\TextColumn::make('status')
                    ->badge()
                    ->formatStateUsing(fn ($state) => Project::getStatuses()[$state] ?? $state)
                    ->color(fn ($state) => match($state) {
                        Project::STATUS_NEW => 'info',
                        Project::STATUS_APPROVED => 'success',
                        Project::STATUS_REJECTED => 'danger',
                        default => 'gray',
                    })
                    ->sortable(),
                Tables\Columns\TextColumn::make('user.name')
                    ->label('Responsible')
                    ->sortable()
                    ->toggleable(),
                Tables\Columns\TextColumn::make('project_year')
                    ->date('Y')
                    ->sortable()
                    ->toggleable(),
                Tables\Columns\TextColumn::make('deadline')
                    ->date('d-m-Y')
                    ->sortable(),
                Tables\Columns\TextColumn::make('contracts_count')
                    ->counts('contracts')
                    ->label('Contracts')
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime('d-m-Y H:i')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('status')
                    ->options(Project::getStatuses()),
                Tables\Filters\SelectFilter::make('user_id')
                    ->label('Responsible User')
                    ->relationship('user', 'name')
                    ->searchable()
                    ->preload(),
                Tables\Filters\SelectFilter::make('currency_id')
                    ->label('Currency')
                    ->relationship('currency', 'short_name')
                    ->searchable()
                    ->preload(),
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
            'index' => Pages\ListProjects::route('/'),
            'create' => Pages\CreateProject::route('/create'),
            'edit' => Pages\EditProject::route('/{record}/edit'),
        ];
    }
}
