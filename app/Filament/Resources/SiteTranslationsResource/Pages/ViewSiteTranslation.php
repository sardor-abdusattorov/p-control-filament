<?php

namespace App\Filament\Resources\SiteTranslationsResource\Pages;

use App\Filament\Resources\SiteTranslationsResource;
use Filament\Actions\DeleteAction;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;


class ViewSiteTranslation extends ViewRecord
{
    protected static string $resource = SiteTranslationsResource::class;

    protected function getHeaderActions(): array
    {
        return [
            EditAction::make(),
            DeleteAction::make(),
        ];
    }
}
