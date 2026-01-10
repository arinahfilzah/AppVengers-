<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Subject extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'year_level',
        'downloads',
        'resources',
        'rating',
        'trend',
        'growth',
        'created_at'
    ];

    protected $casts = [
        'rating' => 'decimal:1',
        'growth' => 'decimal:2'
    ];
}