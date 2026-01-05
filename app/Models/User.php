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
        'wallet_balance',
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
        'premium_expires_at' => 'datetime',
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


    // Check if user is premium
    public function isPremium()
    {
        return $this->account_type === 'premium' 
            && $this->premium_expires_at 
            && now()->lessThan($this->premium_expires_at);
    }

    // Check if user is basic
    public function isBasic()
    {
        return $this->account_type === 'basic';
    }

    // Upgrade user to premium
    public function upgradeToPremium($days = 30)
    {
        $this->account_type = 'premium';
        $this->premium_expires_at = now()->addDays($days);
        $this->save();
    }

    // Downgrade user to basic
    public function downgradeToBasic()
    {
        $this->account_type = 'basic';
        $this->premium_expires_at = null;
        $this->save();
    }

    // Get days remaining for premium
    public function getPremiumDaysRemaining()
    {
        if (!$this->premium_expires_at) {
            return 0;
        }
        return now()->diffInDays($this->premium_expires_at, false);
    }

    // Relationship with mock payments
    public function mockPayments()
    {
        return $this->hasMany(MockPayment::class);
    }

    public function deductBalance($amount)
    {
        $this->wallet_balance -= $amount;
        $this->save();
    }
}
