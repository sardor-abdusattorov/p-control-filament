<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Approval extends Model
{
    use HasFactory;

    protected $fillable = [
        'approvable_type',
        'approvable_id',
        'user_id',
        'approval_order',
        'approved',
        'reason',
        'approved_at',
    ];

    protected $casts = [
        'approved' => 'boolean',
        'approved_at' => 'datetime',
    ];

    const STATUS_NEW = 0;
    const STATUS_PENDING = 1;
    const STATUS_APPROVED = 2;
    const STATUS_REJECTED = -1;
    const STATUS_INVALIDATED = -2;

    /**
     * Get available statuses
     */
    public static function getStatuses(): array
    {
        return [
            self::STATUS_NEW => __('New'),
            self::STATUS_PENDING => __('Pending'),
            self::STATUS_APPROVED => __('Approved'),
            self::STATUS_REJECTED => __('Rejected'),
            self::STATUS_INVALIDATED => __('Invalidated'),
        ];
    }

    /**
     * Polymorphic relationship to approvable models
     */
    public function approvable()
    {
        return $this->morphTo();
    }

    /**
     * Relationship with User
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * Scope for valid approvals (exclude invalidated)
     */
    public function scopeValid($query)
    {
        return $query->where('approved', '!=', self::STATUS_INVALIDATED);
    }

    /**
     * Scope for active approvals
     */
    public function scopeActive($query)
    {
        return $query->whereNotIn('approved', [self::STATUS_INVALIDATED, self::STATUS_NEW]);
    }

    /**
     * Get approval order based on department
     * Financial department: 1
     * Legal department: 2
     * Others: 1
     */
    public static function getApprovalOrder($departmentName): int
    {
        $departmentName = strtolower($departmentName);

        if (str_contains($departmentName, 'financ') || str_contains($departmentName, 'бухгалтер')) {
            return 1;
        }

        if (str_contains($departmentName, 'legal') || str_contains($departmentName, 'юрид')) {
            return 2;
        }

        return 1;
    }
}
