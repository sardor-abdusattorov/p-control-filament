<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;

class Currency extends Model
{
    use HasFactory, HasTranslations;

    protected $table = 'currencies';

    public $translatable = ['name'];

    protected $fillable = [
        'name',
        'short_name',
        'value',
        'status',
    ];

    protected $casts = [
        'status' => 'boolean',
        'value' => 'decimal:2',
    ];

    const STATUS_INACTIVE = 0;
    const STATUS_ACTIVE = 1;

    /**
     * Get available statuses
     */
    public static function getStatuses(): array
    {
        return [
            self::STATUS_ACTIVE => __('Active'),
            self::STATUS_INACTIVE => __('Inactive'),
        ];
    }

    /**
     * Scope for active currencies
     */
    public function scopeActive($query)
    {
        return $query->where('status', self::STATUS_ACTIVE);
    }

    /**
     * Get formatted created_at
     */
    public function getCreatedAtAttribute($value)
    {
        return $value ? date('d-m-Y H:i', strtotime($value)) : null;
    }

    /**
     * Get formatted updated_at
     */
    public function getUpdatedAtAttribute($value)
    {
        return $value ? date('d-m-Y H:i', strtotime($value)) : null;
    }
}
