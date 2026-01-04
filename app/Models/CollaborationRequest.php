<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CollaborationRequest extends Model
{
    protected $fillable = [
        'resource_id',
        'requester_id',
        'status',
        'message',
        'responded_at'
    ];

    protected $casts = [
        'responded_at' => 'datetime',
    ];

    // Relationship with Resource
    public function resource()
    {
        return $this->belongsTo(Resource::class);
    }

    // Relationship with User (Requester)
    public function requester()
    {
        return $this->belongsTo(User::class, 'requester_id');
    }

    // Check if request is pending
    public function isPending()
    {
        return $this->status === 'pending';
    }

    // Check if request is approved
    public function isApproved()
    {
        return $this->status === 'approved';
    }

    // Check if request is rejected
    public function isRejected()
    {
        return $this->status === 'rejected';
    }
}