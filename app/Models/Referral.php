<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Referral extends Model
{
    use HasFactory;

    protected $fillable = [
        'referrer_id',
        'referred_id',
        'status',
        'reward_amount',
        'booking_type',
        'booking_id',
        'completed_at',
        'rewarded_at',
    ];

    protected $casts = [
        'reward_amount' => 'decimal:2',
        'completed_at' => 'datetime',
        'rewarded_at' => 'datetime',
    ];

    /**
     * Get the user who made the referral
     */
    public function referrer(): BelongsTo
    {
        return $this->belongsTo(User::class, 'referrer_id');
    }

    /**
     * Get the user who was referred
     */
    public function referred(): BelongsTo
    {
        return $this->belongsTo(User::class, 'referred_id');
    }

    /**
     * Mark referral as completed
     */
    public function markAsCompleted(string $bookingType, int $bookingId, float $rewardAmount): void
    {
        $this->update([
            'status' => 'completed',
            'booking_type' => $bookingType,
            'booking_id' => $bookingId,
            'reward_amount' => $rewardAmount,
            'completed_at' => now(),
        ]);

        // Update referrer's stats
        $this->referrer->increment('referral_count');
        $this->referrer->increment('referral_earnings', $rewardAmount);
    }

    /**
     * Mark referral as rewarded
     */
    public function markAsRewarded(): void
    {
        $this->update([
            'status' => 'rewarded',
            'rewarded_at' => now(),
        ]);
    }
}
