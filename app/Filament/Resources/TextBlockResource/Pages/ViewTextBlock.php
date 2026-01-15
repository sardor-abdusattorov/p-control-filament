<?php

namespace App\Filament\Resources\TextBlockResource\Pages;

use App\Filament\Resources\TextBlockResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;

class ViewTextBlock extends ViewRecord
{
    protected static string $resource = TextBlockResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\EditAction::make(),
        ];
    }
}
