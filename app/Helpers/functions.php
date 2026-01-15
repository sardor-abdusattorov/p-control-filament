<?php

use App\Models\SiteSettings;
use App\Models\SiteTranslation;
use App\Models\Gallery;
use Awcodes\Curator\Models\Media;

if (! function_exists('site_setting')) {
    function site_setting(string $key, mixed $default = null): mixed
    {
        $setting = SiteSettings::query()->where('name', $key)->first();
        return $setting ? $setting->value : $default;
    }
}

if (! function_exists('translator')) {
    function translator($category, $key = null, $replace = [], $locale = null)
    {
        $locale = $locale ?: app()->getLocale();
        if ($key === null && str_contains($category, '.')) {
            [$category, $key] = explode('.', $category, 2);
        }

        if ($key === null) {
            return $category;
        }

        $row = SiteTranslation::where('category', $category)->where('key', $key)->first();
        if (! $row) {
            return $key;
        }
        $value = $row->value;
        if (is_array($value) && isset($value[$locale])) {
            $value = $value[$locale];
        } elseif (is_array($value)) {
            $value = reset($value);
        }
        if (is_array($replace)) {
            foreach ($replace as $k => $v) {
                $value = str_replace(':'.$k, $v, $value);
            }
        }
        return $value;
    }
}
