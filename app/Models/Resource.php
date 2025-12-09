<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Resource extends Model
{
    protected $fillable = [
        'title',
        'description',
        'category',
        'year',
        'subject',
        'file_path',
        'qr_code_path',
        'access_token',
        'upload_date',
        'uploader_id'
    ];

    protected $casts = [
        'upload_date' => 'datetime',
    ];

    // Relationship with User
    public function uploader()
    {
        return $this->belongsTo(User::class, 'uploader_id');
    }
}