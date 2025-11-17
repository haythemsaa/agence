<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class PackageBooking extends Model
{
    use HasFactory;

    protected $fillable = [
        'booking_reference',
        'user_id',
        'travel_package_id',
        'departure_date',
        'return_date',
        'nb_adults',
        'nb_children',
        'nb_infants',
        'participants',
        'contact_first_name',
        'contact_last_name',
        'contact_email',
        'contact_phone',
        'adults_price',
        'children_price',
        'supplements',
        'discount',
        'total_price',
        'currency',
        'has_installment_plan',
        'installment_plan',
        'paid_amount',
        'remaining_amount',
        'has_travel_insurance',
        'special_requests',
        'status',
        'cancellation_reason',
        'cancelled_at',
        'convocation_document',
        'voucher_document',
    ];

    protected function casts(): array
    {
        return [
            'departure_date' => 'date',
            'return_date' => 'date',
            'participants' => 'array',
            'adults_price' => 'decimal:2',
            'children_price' => 'decimal:2',
            'supplements' => 'decimal:2',
            'discount' => 'decimal:2',
            'total_price' => 'decimal:2',
            'has_installment_plan' => 'boolean',
            'installment_plan' => 'array',
            'paid_amount' => 'decimal:2',
            'remaining_amount' => 'decimal:2',
            'has_travel_insurance' => 'boolean',
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

    public function travelPackage()
    {
        return $this->belongsTo(TravelPackage::class);
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
        return $query->whereIn('status', ['confirmed', 'paid', 'partially_paid']);
    }

    public function scopeUpcoming($query)
    {
        return $query->where('departure_date', '>', now());
    }

    /**
     * Generate unique booking reference
     */
    public static function generateReference(): string
    {
        return 'PB-' . strtoupper(substr(uniqid(), -8));
    }

    /**
     * Record a payment
     */
    public function recordPayment(float $amount): void
    {
        $this->paid_amount += $amount;
        $this->remaining_amount = max(0, $this->total_price - $this->paid_amount);

        if ($this->remaining_amount == 0) {
            $this->status = 'paid';
        } elseif ($this->paid_amount > 0) {
            $this->status = 'partially_paid';
        }

        $this->save();
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

    /**
     * Check if fully paid
     */
    public function isFullyPaid(): bool
    {
        return $this->remaining_amount == 0 && $this->paid_amount >= $this->total_price;
    }
}
