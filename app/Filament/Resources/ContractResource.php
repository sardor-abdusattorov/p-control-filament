<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ContractResource\Pages;
use App\Filament\Resources\ContractResource\RelationManagers;
use App\Models\Contract;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class ContractResource extends Resource
{
    protected static ?string $model = Contract::class;

    protected static ?string $navigationIcon = 'heroicon-o-document-check';

    public static function getNavigationGroup(): ?string
    {
        return __('app.label.projects_and_contracts');
    }

    protected static ?int $navigationSort = 3;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Contract Information')
                    ->schema([
                        Forms\Components\Grid::make(2)
                            ->schema([
                                Forms\Components\TextInput::make('contract_number')
                                    ->maxLength(255),
                                Forms\Components\TextInput::make('title')
                                    ->required()
                                    ->maxLength(255)
                                    ->columnSpanFull(),
                            ]),
                    ]),

                Forms\Components\Section::make('Relationships')
                    ->schema([
                        Forms\Components\Grid::make(2)
                            ->schema([
                                Forms\Components\Select::make('project_id')
                                    ->label('Project')
                                    ->relationship('project', 'title')
                                    ->searchable()
                                    ->preload()
                                    ->required(),
                                Forms\Components\Select::make('application_id')
                                    ->label('Application')
                                    ->relationship('application', 'title')
                                    ->searchable()
                                    ->preload(),
                            ]),
                        Forms\Components\Grid::make(2)
                            ->schema([
                                Forms\Components\Select::make('contact_id')
                                    ->label('Contact')
                                    ->relationship('contact', 'firstname')
                                    ->getOptionLabelFromRecordUsing(fn ($record) => "{$record->firstname} {$record->lastname}" . ($record->company ? " ({$record->company})" : ''))
                                    ->searchable(['firstname', 'lastname', 'company'])
                                    ->preload(),
                                Forms\Components\Select::make('user_id')
                                    ->label('Responsible User')
                                    ->relationship('user', 'name')
                                    ->searchable()
                                    ->preload()
                                    ->required(),
                            ]),
                    ]),

                Forms\Components\Section::make('Financial Information')
                    ->schema([
                        Forms\Components\Grid::make(3)
                            ->schema([
                                Forms\Components\TextInput::make('budget_sum')
                                    ->required()
                                    ->numeric()
                                    ->prefix('$')
                                    ->maxValue(99999999999999.99),
                                Forms\Components\Select::make('currency_id')
                                    ->label('Currency')
                                    ->relationship('currency', 'short_name')
                                    ->searchable()
                                    ->preload(),
                                Forms\Components\Select::make('transaction_type')
                                    ->options(Contract::getTransactionTypes())
                                    ->required()
                                    ->default(Contract::TYPE_EXPENSE),
                            ]),
                    ]),

                Forms\Components\Section::make('Status & Deadline')
                    ->schema([
                        Forms\Components\Grid::make(2)
                            ->schema([
                                Forms\Components\Select::make('status')
                                    ->options(Contract::getStatuses())
                                    ->required()
                                    ->default(Contract::STATUS_NEW),
                                Forms\Components\DatePicker::make('deadline')
                                    ->required(),
                            ]),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('id')
                    ->label('ID')
                    ->sortable(),
                Tables\Columns\TextColumn::make('contract_number')
                    ->searchable()
                    ->sortable()
                    ->toggleable(),
                Tables\Columns\TextColumn::make('title')
                    ->searchable()
                    ->sortable()
                    ->limit(40),
                Tables\Columns\TextColumn::make('project.title')
                    ->searchable()
                    ->sortable()
                    ->limit(30)
                    ->toggleable(),
                Tables\Columns\TextColumn::make('contact.firstname')
                    ->label('Contact')
                    ->formatStateUsing(fn ($record) =>
                        $record->contact
                            ? "{$record->contact->firstname} {$record->contact->lastname}"
                            : '-'
                    )
                    ->searchable(['firstname', 'lastname'])
                    ->toggleable(),
                Tables\Columns\TextColumn::make('budget_sum')
                    ->money()
                    ->sortable(),
                Tables\Columns\TextColumn::make('currency.short_name')
                    ->label('Currency')
                    ->sortable()
                    ->toggleable(),
                Tables\Columns\TextColumn::make('transaction_type')
                    ->badge()
                    ->formatStateUsing(fn ($state) => Contract::getTransactionTypes()[$state] ?? $state)
                    ->color(fn ($state) => match($state) {
                        Contract::TYPE_EXPENSE => 'danger',
                        Contract::TYPE_INCOME => 'success',
                        default => 'gray',
                    })
                    ->sortable(),
                Tables\Columns\TextColumn::make('status')
                    ->badge()
                    ->formatStateUsing(fn ($state) => Contract::getStatuses()[$state] ?? $state)
                    ->color(fn ($state) => match($state) {
                        Contract::STATUS_NEW => 'gray',
                        Contract::STATUS_IN_PROGRESS => 'info',
                        Contract::STATUS_APPROVED => 'success',
                        Contract::STATUS_REJECTED => 'danger',
                        Contract::STATUS_INVALIDATED => 'warning',
                        default => 'gray',
                    })
                    ->sortable(),
                Tables\Columns\TextColumn::make('deadline')
                    ->date('d-m-Y')
                    ->sortable(),
                Tables\Columns\TextColumn::make('user.name')
                    ->label('Responsible')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime('d-m-Y H:i')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('project_id')
                    ->label('Project')
                    ->relationship('project', 'title')
                    ->searchable()
                    ->preload(),
                Tables\Filters\SelectFilter::make('contact_id')
                    ->label('Contact')
                    ->relationship('contact', 'firstname')
                    ->searchable()
                    ->preload(),
                Tables\Filters\SelectFilter::make('transaction_type')
                    ->options(Contract::getTransactionTypes()),
                Tables\Filters\SelectFilter::make('status')
                    ->options(Contract::getStatuses()),
                Tables\Filters\SelectFilter::make('user_id')
                    ->label('Responsible User')
                    ->relationship('user', 'name')
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
            'index' => Pages\ListContracts::route('/'),
            'create' => Pages\CreateContract::route('/create'),
            'edit' => Pages\EditContract::route('/{record}/edit'),
        ];
    }
}
