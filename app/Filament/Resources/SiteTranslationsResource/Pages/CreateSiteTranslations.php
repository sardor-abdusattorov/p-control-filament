<?php

namespace App\Filament\Resources\SiteTranslationsResource\Pages;

use App\Filament\Resources\SiteTranslationsResource;
use Filament\Resources\Pages\CreateRecord;

class CreateSiteTranslations extends CreateRecord
{
    protected static string $resource = SiteTranslationsResource::class;

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
