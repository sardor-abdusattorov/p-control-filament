<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Contact extends Model
{
    use HasFactory;

    protected $fillable = [
        'prefix',
        'firstname',
        'lastname',
        'title',
        'company',
        'phone',
        'email',
        'cellphone',
        'address',
        'address2',
        'post_box',
        'zip_code',
        'country',
        'city',
        'language',
        'owner_id',
        'category_id',
        'subcategory_id',
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
     * Relationship with category
     */
    public function category()
    {
        return $this->belongsTo(ContactCategory::class, 'category_id');
    }

    /**
     * Relationship with subcategory
     */
    public function subcategory()
    {
        return $this->belongsTo(ContactSubcategory::class, 'subcategory_id');
    }

    /**
     * Relationship with owner (User)
     */
    public function owner()
    {
        return $this->belongsTo(User::class, 'owner_id');
    }

    /**
     * Scope for active contacts
     */
    public function scopeActive($query)
    {
        return $query->where('status', self::STATUS_ACTIVE);
    }

    /**
     * Get full name
     */
    public function getFullNameAttribute()
    {
        return trim("{$this->firstname} {$this->lastname}");
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
