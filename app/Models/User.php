<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'last_login',
        'session_timeout',
        'recovery_email',
        'recovery_phone',
        'trusted_devices',
        'security_notifications',
        'profile_picture',
        'phone_number',
        'account_status',
        'suspended_reason',
    ];    

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'last_login' => 'datetime',
        'trusted_devices' => 'array',
        'security_notifications' => 'boolean',
    ];    

    /**
     * Login History Relationship
     * UC03 – A user can have many login history records
     */
    public function loginHistories()
    {
        return $this->hasMany(LoginHistory::class);
    }
}
