<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Rating extends Model
{
    protected $fillable = [
        'resource_id',
        'user_id',
        'rating',
        'comment',
        'reviewed_at'
    ];

    protected $casts = [
        'rating' => 'float',
        'reviewed_at' => 'datetime'
    ];

    public function resource(): BelongsTo
    {
        return $this->belongsTo(Resource::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}