<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ApplicationResource\Pages;
use App\Filament\Resources\ApplicationResource\RelationManagers;
use App\Models\Application;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class ApplicationResource extends Resource
{
    protected static ?string $model = Application::class;

    protected static ?string $navigationIcon = 'heroicon-o-document-text';

    public static function getNavigationGroup(): ?string
    {
        return __('app.label.projects_and_contracts');
    }

    protected static ?int $navigationSort = 2;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Application Information')
                    ->schema([
                        Forms\Components\Grid::make(2)
                            ->schema([
                                Forms\Components\TextInput::make('title')
                                    ->required()
                                    ->maxLength(255)
                                    ->columnSpanFull(),
                                Forms\Components\Select::make('project_id')
                                    ->label('Project')
                                    ->relationship('project', 'title')
                                    ->searchable()
                                    ->preload()
                                    ->required()
                                    ->createOptionForm([
                                        Forms\Components\TextInput::make('title')
                                            ->required()
                                            ->maxLength(500),
                                        Forms\Components\DatePicker::make('project_year')
                                            ->required(),
                                        Forms\Components\DatePicker::make('deadline')
                                            ->required(),
                                    ]),
                                Forms\Components\Select::make('type')
                                    ->options(Application::getTypes())
                                    ->required()
                                    ->default(Application::TYPE_REQUEST),
                            ]),
                        Forms\Components\Grid::make(3)
                            ->schema([
                                Forms\Components\Select::make('user_id')
                                    ->label('Responsible User')
                                    ->relationship('user', 'name')
                                    ->searchable()
                                    ->preload()
                                    ->required(),
                                Forms\Components\Select::make('currency_id')
                                    ->label('Currency')
                                    ->relationship('currency', 'short_name')
                                    ->searchable()
                                    ->preload(),
                                Forms\Components\Select::make('status')
                                    ->options(Application::getStatuses())
                                    ->required()
                                    ->default(Application::STATUS_NEW),
                            ]),
                    ]),

                Forms\Components\Section::make('Documents')
                    ->schema([
                        Forms\Components\SpatieMediaLibraryFileUpload::make('documents')
                            ->collection('documents')
                            ->multiple()
                            ->reorderable()
                            ->downloadable()
                            ->openable()
                            ->acceptedFileTypes(['application/pdf', 'application/msword', 'application/vnd.openxmlformats-officedocument.wordprocessingml.document', 'application/vnd.ms-excel', 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet', 'image/*'])
                            ->maxSize(10240)
                            ->helperText('Upload documents (PDF, Word, Excel, Images). Max 10MB per file.'),
                    ])
                    ->collapsed(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('id')
                    ->label('ID')
                    ->sortable(),
                Tables\Columns\TextColumn::make('title')
                    ->searchable()
                    ->sortable()
                    ->limit(40),
                Tables\Columns\TextColumn::make('project.title')
                    ->searchable()
                    ->sortable()
                    ->limit(30)
                    ->toggleable(),
                Tables\Columns\TextColumn::make('type')
                    ->badge()
                    ->formatStateUsing(fn ($state) => Application::getTypes()[$state] ?? $state)
                    ->color(fn ($state) => match($state) {
                        Application::TYPE_REQUEST => 'info',
                        Application::TYPE_MEMORANDUM => 'warning',
                        default => 'gray',
                    })
                    ->sortable(),
                Tables\Columns\TextColumn::make('status')
                    ->badge()
                    ->formatStateUsing(fn ($state) => Application::getStatuses()[$state] ?? $state)
                    ->color(fn ($state) => match($state) {
                        Application::STATUS_NEW => 'gray',
                        Application::STATUS_IN_PROGRESS => 'info',
                        Application::STATUS_APPROVED => 'success',
                        Application::STATUS_REJECTED => 'danger',
                        Application::STATUS_INVALIDATED => 'warning',
                        default => 'gray',
                    })
                    ->sortable(),
                Tables\Columns\TextColumn::make('user.name')
                    ->label('Responsible')
                    ->sortable()
                    ->toggleable(),
                Tables\Columns\TextColumn::make('currency.short_name')
                    ->label('Currency')
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
                Tables\Filters\SelectFilter::make('type')
                    ->options(Application::getTypes()),
                Tables\Filters\SelectFilter::make('status')
                    ->options(Application::getStatuses()),
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
            'index' => Pages\ListApplications::route('/'),
            'create' => Pages\CreateApplication::route('/create'),
            'edit' => Pages\EditApplication::route('/{record}/edit'),
        ];
    }
}
