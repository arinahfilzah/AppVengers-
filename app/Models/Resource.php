<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\ResourceVersion;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;


class Resource extends Model
{
    protected $fillable = [
        'title',
        'description',
        'category',
        'year',
        'subject',
        'file_path',
        'current_version',
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

    // Relationship with versions
    public function versions()
    {
        return $this->hasMany(ResourceVersion::class)->orderBy('version_number', 'desc');
    }

    // Get latest version
    public function latestVersion()
    {
        return $this->hasOne(ResourceVersion::class)->latestOfMany('version_number');
    }


    public function collaborators()
    {
        return $this->belongsToMany(User::class, 'resource_user');
    }
}
