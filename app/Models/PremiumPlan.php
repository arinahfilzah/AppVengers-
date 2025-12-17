<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PremiumPlan extends Model
{
    use HasFactory;

    protected $fillable = [
        'name', 'code', 'description', 'price', 
        'duration_days', 'is_active', 'features', 'sort_order'
    ];

    protected $casts = [
        'price' => 'decimal:2',
        'is_active' => 'boolean',
        'features' => 'array',
    ];

    // Get active plans
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    // Get formatted price
    public function getFormattedPriceAttribute()
    {
        return 'LKR ' . number_format($this->price, 2);
    }
}