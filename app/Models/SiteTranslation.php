<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SiteTranslation extends Model
{
    protected $table = 'site_translations';

    protected $fillable = ['category', 'key', 'value'];

    public $translatable = ['value'];

    protected $casts = [
        'value' => 'array',
    ];
}
