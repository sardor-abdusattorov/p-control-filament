<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
// Если используешь spatie/laravel-translatable:
use Spatie\Translatable\HasTranslations;

class TextBlock extends Model
{
    use HasTranslations;

    protected $table = 'text_blocks';

    protected $fillable = [
        'name',
        'title',
        'content',
        'image',
        'status',
    ];

    public $translatable = ['title', 'content'];

    public const STATUS_ACTIVE = 1;
    public const STATUS_INACTIVE = 0;

    public const STATUSES = [
        self::STATUS_ACTIVE   => 'Активен',
        self::STATUS_INACTIVE => 'Неактивен',
    ];

    public function scopeActive($query)
    {
        return $query->where('status', true);
    }
}
