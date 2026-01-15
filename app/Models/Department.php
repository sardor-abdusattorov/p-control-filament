<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;

class Department extends Model
{
    use HasFactory, HasTranslations;

    public $translatable = ['name'];

    protected $fillable = [
        'name',
        'head_of_department',
        'status',
    ];

    protected $casts = [
        'status' => 'boolean',
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
     * Relationship with User (head of department)
     */
    public function head()
    {
        return $this->belongsTo(User::class, 'head_of_department');
    }

    /**
     * Scope for active departments
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
