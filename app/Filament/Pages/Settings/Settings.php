<?php

namespace App\Filament\Pages\Settings;

use AbdulmajeedJamaan\FilamentTranslatableTabs\TranslatableTabs;
use Closure;

use Filament\Forms;
use Filament\Forms\Form;
use Filament\Forms\Get;
use Illuminate\Support\Facades\Storage;
use Outerweb\FilamentSettings\Filament\Pages\Settings as BaseSettings;

class Settings extends BaseSettings
{

    public static function getNavigationLabel(): string
    {
        return __('app.label.main_settings');
    }

    protected static ?int $navigationSort = 1;

    public function getTitle(): string
    {
        return __('app.label.main_settings');
    }

    protected static ?string $navigationGroup = 'settings';

    public static function getNavigationGroup(): ?string
    {
        return __('app.label.settings');
    }

    public function schema(): array|Closure
    {
        return [
            Forms\Components\Tabs::make(__('app.label.settings'))
                ->persistTabInQueryString()
                ->schema([
                    Forms\Components\Tabs\Tab::make(__('app.label.tab_seo'))
                        ->schema([

                            TranslatableTabs::make('seo_translations')
                                ->schema([
                                    Forms\Components\TextInput::make('seo.title')
                                        ->label(__('app.label.seo_title'))
                                        ->required(),

                                    Forms\Components\Textarea::make('seo.description')
                                        ->label(__('app.label.seo_description'))
                                        ->rows(4)
                                        ->required(),

                                    Forms\Components\Textarea::make('seo.keywords')
                                        ->label(__('app.label.seo_keywords'))
                                        ->rows(4),
                                ]),

                            Forms\Components\FileUpload::make('seo.og_image')
                                ->label(__('app.label.seo_og_image'))
                                ->imageEditor()
                                ->required()
                                ->imagePreviewHeight('250')
                                ->directory('og_images')
                                ->maxSize(2048)
                                ->acceptedFileTypes(['image/png'])
                                ->helperText(__('app.label.seo_og_image_helper'))
                                ->deleteUploadedFileUsing(
                                    fn ($file) => Storage::disk('public')->delete($file)
                                ),
                        ]),

                    Forms\Components\Tabs\Tab::make(__('app.label.tab_metrics'))
                        ->schema([
                            Forms\Components\Textarea::make('metrics.yandex')
                                ->label(__('app.label.metrics_yandex'))
                                ->rows(6)
                                ->helperText(__('app.label.metrics_yandex_helper')),

                            Forms\Components\Textarea::make('metrics.google')
                                ->label(__('app.label.metrics_google'))
                                ->rows(6)
                                ->helperText(__('app.label.metrics_google_helper')),
                        ]),
                ]),
        ];
    }
}
