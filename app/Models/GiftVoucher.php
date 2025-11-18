<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class GiftVoucher extends Model
{
    protected $fillable = [
        'code',
        'purchaser_id',
        'purchaser_name',
        'purchaser_email',
        'recipient_name',
        'recipient_email',
        'personal_message',
        'amount',
        'currency',
        'remaining_balance',
        'status',
        'valid_until',
        'redeemed_by',
        'redeemed_at',
        'booking_id',
        'booking_type',
    ];

    protected $casts = [
        'amount' => 'decimal:2',
        'remaining_balance' => 'decimal:2',
        'valid_until' => 'datetime',
        'redeemed_at' => 'datetime',
    ];

    /**
     * Generate unique voucher code
     */
    public static function generateCode(): string
    {
        do {
            $code = 'GV-' . strtoupper(Str::random(12));
        } while (self::where('code', $code)->exists());

        return $code;
    }

    /**
     * Check if voucher is valid
     */
    public function isValid(): bool
    {
        return $this->status === 'active'
            && $this->remaining_balance > 0
            && $this->valid_until->isFuture();
    }

    /**
     * Redeem voucher
     */
    public function redeem(float $amount, int $userId, int $bookingId = null, string $bookingType = null): bool
    {
        if (!$this->isValid() || $amount > $this->remaining_balance) {
            return false;
        }

        $this->remaining_balance -= $amount;

        if ($this->remaining_balance <= 0) {
            $this->status = 'redeemed';
            $this->redeemed_by = $userId;
            $this->redeemed_at = now();
        }

        if ($bookingId) {
            $this->booking_id = $bookingId;
            $this->booking_type = $bookingType;
        }

        return $this->save();
    }

    /**
     * Relationships
     */
    public function purchaser()
    {
        return $this->belongsTo(User::class, 'purchaser_id');
    }

    public function redeemedBy()
    {
        return $this->belongsTo(User::class, 'redeemed_by');
    }

    /**
     * Scopes
     */
    public function scopeActive($query)
    {
        return $query->where('status', 'active')
            ->where('valid_until', '>', now())
            ->where('remaining_balance', '>', 0);
    }

    public function scopeExpired($query)
    {
        return $query->where('valid_until', '<=', now())
            ->where('status', '!=', 'redeemed');
    }
}
