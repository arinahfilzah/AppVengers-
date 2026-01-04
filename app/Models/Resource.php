<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\ResourceVersion;
use App\Models\CollaborationRequest;
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

    // Relationship with User (Uploader)
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

    // Relationship with collaborators (Many-to-Many)
    public function collaborators()
    {
        return $this->belongsToMany(User::class, 'resource_user');
    }

    // Relationship with collaboration requests
    public function collaborationRequests()
    {
        return $this->hasMany(CollaborationRequest::class);
    }

    // Get pending collaboration requests
    public function pendingCollaborationRequests()
    {
        return $this->hasMany(CollaborationRequest::class)->where('status', 'pending');
    }

    // Check if user has pending request
    public function hasPendingRequestFrom($userId)
    {
        return $this->collaborationRequests()
            ->where('requester_id', $userId)
            ->where('status', 'pending')
            ->exists();
    }

    // Check if user is collaborator
    public function hasCollaborator($userId)
    {
        return $this->collaborators()->where('user_id', $userId)->exists();
    }

    // Check if user can edit (owner or collaborator)
    public function canBeEditedBy($userId)
    {
        return $this->uploader_id === $userId || $this->hasCollaborator($userId);
    }
}