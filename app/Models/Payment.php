<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Payment extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'booking_type',
        'booking_id',
        'amount',
        'currency',
        'payment_method',
        'transaction_id',
        'payment_intent_id',
        'payer_id',
        'status',
        'payment_metadata',
        'failure_reason',
        'paid_at',
        'refunded_at',
        'refund_amount',
        'refund_transaction_id',
        'refund_reason',
    ];

    protected function casts(): array
    {
        return [
            'amount' => 'decimal:2',
            'refund_amount' => 'decimal:2',
            'payment_metadata' => 'array',
            'paid_at' => 'datetime',
            'refunded_at' => 'datetime',
        ];
    }

    /**
     * Relationships
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function booking()
    {
        return $this->morphTo();
    }

    /**
     * Scopes
     */
    public function scopeCompleted($query)
    {
        return $query->where('status', 'completed');
    }

    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }

    public function scopeFailed($query)
    {
        return $query->where('status', 'failed');
    }

    public function scopeByMethod($query, $method)
    {
        return $query->where('payment_method', $method);
    }

    /**
     * Mark as completed
     */
    public function markAsCompleted(): void
    {
        $this->status = 'completed';
        $this->paid_at = now();
        $this->save();
    }

    /**
     * Mark as failed
     */
    public function markAsFailed(string $reason = null): void
    {
        $this->status = 'failed';
        $this->failure_reason = $reason;
        $this->save();
    }

    /**
     * Process refund
     */
    public function processRefund(float $amount, string $transactionId = null, string $reason = null): void
    {
        $this->status = 'refunded';
        $this->refund_amount = $amount;
        $this->refund_transaction_id = $transactionId;
        $this->refund_reason = $reason;
        $this->refunded_at = now();
        $this->save();
    }
}
