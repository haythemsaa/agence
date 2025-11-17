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
        'phone',
        'role',
        'loyalty_points',
        'loyalty_level',
        'birth_date',
        'gender',
        'country',
        'city',
        'address',
        'postal_code',
        'newsletter_subscribed',
        'is_active',
        'referral_code',
        'referred_by_id',
        'referral_count',
        'referral_earnings',
        'referral_reward_claimed_at',
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
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'birth_date' => 'date',
            'newsletter_subscribed' => 'boolean',
            'is_active' => 'boolean',
        ];
    }

    /**
     * Relationships
     */
    public function hotelBookings()
    {
        return $this->hasMany(HotelBooking::class);
    }

    public function packageBookings()
    {
        return $this->hasMany(PackageBooking::class);
    }

    public function payments()
    {
        return $this->hasMany(Payment::class);
    }

    public function reviews()
    {
        return $this->hasMany(Review::class);
    }

    public function wishlists()
    {
        return $this->hasMany(Wishlist::class);
    }

    /**
     * Referral relationships
     */
    public function referredBy()
    {
        return $this->belongsTo(User::class, 'referred_by_id');
    }

    public function referrals()
    {
        return $this->hasMany(User::class, 'referred_by_id');
    }

    public function referralsMade()
    {
        return $this->hasMany(Referral::class, 'referrer_id');
    }

    public function referralsReceived()
    {
        return $this->hasMany(Referral::class, 'referred_id');
    }

    /**
     * Check if user is admin
     */
    public function isAdmin(): bool
    {
        return $this->role === 'admin';
    }

    /**
     * Generate unique referral code
     */
    public function generateReferralCode(): string
    {
        do {
            $code = strtoupper(substr(md5(uniqid()), 0, 8));
        } while (self::where('referral_code', $code)->exists());

        $this->update(['referral_code' => $code]);

        return $code;
    }

    /**
     * Get referral link
     */
    public function getReferralLinkAttribute(): string
    {
        if (!$this->referral_code) {
            $this->generateReferralCode();
        }

        return route('register', ['ref' => $this->referral_code]);
    }

    /**
     * Add loyalty points
     */
    public function addLoyaltyPoints(int $points): void
    {
        $this->loyalty_points += $points;
        $this->updateLoyaltyLevel();
        $this->save();
    }

    /**
     * Update loyalty level based on points
     */
    protected function updateLoyaltyLevel(): void
    {
        if ($this->loyalty_points >= 5000) {
            $this->loyalty_level = 'platinum';
        } elseif ($this->loyalty_points >= 2500) {
            $this->loyalty_level = 'gold';
        } elseif ($this->loyalty_points >= 1000) {
            $this->loyalty_level = 'silver';
        } else {
            $this->loyalty_level = 'bronze';
        }
    }
}
