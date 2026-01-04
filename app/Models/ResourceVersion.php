<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ResourceVersion extends Model
{
    use HasFactory;

    protected $fillable = [
        'resource_id',
        'version_number',
        'file_path',
        'change_notes',
        'updated_by',
    ];

    public $timestamps = false;

    protected $casts = [
        'created_at' => 'datetime',
    ];


    public function resource()
    {
        return $this->belongsTo(Resource::class);
    }

    public function updater()
    {
        return $this->belongsTo(User::class, 'updated_by');
    }
}
