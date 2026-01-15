<?php

namespace App\Filament\Resources\SiteTranslationsResource\Pages;

use App\Filament\Resources\SiteTranslationsResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListSiteTranslations extends ListRecords
{
    protected static string $resource = SiteTranslationsResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
