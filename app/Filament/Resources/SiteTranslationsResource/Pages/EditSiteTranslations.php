<?php

namespace App\Filament\Resources\SiteTranslationsResource\Pages;

use App\Filament\Resources\SiteTranslationsResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditSiteTranslations extends EditRecord
{
    protected static string $resource = SiteTranslationsResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
