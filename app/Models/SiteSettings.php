<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Spatie\Translatable\HasTranslations;

class SiteSettings extends Model
{
    protected $table = 'site_settings';

    protected $fillable = ['name', 'value'];

    protected $casts = [
        'value' => 'array',
    ];

    public static function getOgImage($locale = null)
    {
        $locale = $locale ?: app()->getLocale();
        $path = setting('seo.og_image')[$locale] ?? '';

        if (!$path) {
            return null;
        }

        if (!str_starts_with($path, 'http')) {
            return asset(Storage::url($path));
        }

        return $path;
    }

}
