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
     * Check if user is admin
     */
    public function isAdmin(): bool
    {
        return $this->role === 'admin';
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
