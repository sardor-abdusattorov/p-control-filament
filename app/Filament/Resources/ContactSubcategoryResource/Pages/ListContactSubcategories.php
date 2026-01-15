<?php

namespace App\Filament\Resources\ContactSubcategoryResource\Pages;

use App\Filament\Resources\ContactSubcategoryResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListContactSubcategories extends ListRecords
{
    protected static string $resource = ContactSubcategoryResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
