<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;

class ProductCategory extends Model
{
    use HasFactory, HasTranslations;

    public $translatable = ['name'];

    protected $fillable = [
        'name',
        'image',
        'sort',
    ];

    protected $casts = [
        'sort' => 'integer',
    ];

    /**
     * Relationship with products
     */
    public function products()
    {
        return $this->hasMany(Product::class, 'category_id');
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
