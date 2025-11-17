<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class HotelBooking extends Model
{
    use HasFactory;

    protected $fillable = [
        'booking_reference',
        'user_id',
        'hotel_id',
        'check_in',
        'check_out',
        'nights',
        'rooms',
        'adults',
        'children',
        'guest_first_name',
        'guest_last_name',
        'guest_email',
        'guest_phone',
        'hotel_name',
        'hotel_city',
        'hotel_country',
        'room_type',
        'board_type',
        'room_price',
        'taxes',
        'fees',
        'total_price',
        'currency',
        'api_provider',
        'api_booking_id',
        'api_rate_key',
        'api_response',
        'status',
        'cancellation_reason',
        'cancelled_at',
        'has_transfer',
        'has_insurance',
        'special_requests',
    ];

    protected function casts(): array
    {
        return [
            'check_in' => 'date',
            'check_out' => 'date',
            'room_price' => 'decimal:2',
            'taxes' => 'decimal:2',
            'fees' => 'decimal:2',
            'total_price' => 'decimal:2',
            'api_response' => 'array',
            'has_transfer' => 'boolean',
            'has_insurance' => 'boolean',
            'cancelled_at' => 'datetime',
        ];
    }

    /**
     * Relationships
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function hotel()
    {
        return $this->belongsTo(Hotel::class);
    }

    public function payments()
    {
        return $this->morphMany(Payment::class, 'booking');
    }

    /**
     * Scopes
     */
    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }

    public function scopeConfirmed($query)
    {
        return $query->where('status', 'confirmed');
    }

    public function scopeUpcoming($query)
    {
        return $query->where('check_in', '>', now())->where('status', 'confirmed');
    }

    public function scopePast($query)
    {
        return $query->where('check_out', '<', now());
    }

    /**
     * Generate unique booking reference
     */
    public static function generateReference(): string
    {
        return 'HB-' . strtoupper(substr(uniqid(), -8));
    }

    /**
     * Cancel booking
     */
    public function cancel(string $reason = null): void
    {
        $this->status = 'cancelled';
        $this->cancellation_reason = $reason;
        $this->cancelled_at = now();
        $this->save();
    }
}
