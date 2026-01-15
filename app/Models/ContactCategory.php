<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;

class ContactCategory extends Model
{
    use HasFactory, HasTranslations;

    public $translatable = ['title', 'info'];

    protected $fillable = [
        'title',
        'status',
        'info',
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
     * Relationship with contacts
     */
    public function contacts()
    {
        return $this->hasMany(Contact::class, 'category_id');
    }

    /**
     * Relationship with subcategories
     */
    public function subcategories()
    {
        return $this->hasMany(ContactSubcategory::class, 'category_id');
    }

    /**
     * Scope for active categories
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
