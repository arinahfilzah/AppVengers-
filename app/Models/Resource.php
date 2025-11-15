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
        'upload_date',
        'uploader_id'
    ];
}

