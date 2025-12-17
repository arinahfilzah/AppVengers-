<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MockPayment extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id', 'plan_id', 'transaction_id', 'amount',
        'currency', 'status', 'payment_method', 'card_last_four',
        'card_brand', 'payment_details', 'processed_at'
    ];

    protected $casts = [
        'amount' => 'decimal:2',
        'payment_details' => 'array',
        'processed_at' => 'datetime',
    ];

    // Relationships
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function plan()
    {
        return $this->belongsTo(PremiumPlan::class);
    }

    // Generate unique transaction ID
    public static function generateTransactionId()
    {
        return 'MOCK-' . strtoupper(uniqid()) . '-' . date('Ymd');
    }

    // Check if payment is successful
    public function isSuccessful()
    {
        return $this->status === 'success';
    }
}