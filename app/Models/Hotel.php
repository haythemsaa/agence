<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Hotel extends Model
{
    use HasFactory;

    protected $fillable = [
        'api_provider',
        'api_hotel_id',
        'name',
        'city',
        'country',
        'address',
        'postal_code',
        'latitude',
        'longitude',
        'stars',
        'description',
        'amenities',
        'images',
        'rating',
        'reviews_count',
        'phone',
        'email',
        'website',
        'is_featured',
        'is_active',
    ];

    protected function casts(): array
    {
        return [
            'amenities' => 'array',
            'images' => 'array',
            'latitude' => 'float',
            'longitude' => 'float',
            'rating' => 'decimal:2',
            'is_featured' => 'boolean',
            'is_active' => 'boolean',
        ];
    }

    /**
     * Relationships
     */
    public function bookings()
    {
        return $this->hasMany(HotelBooking::class);
    }

    public function reviews()
    {
        return $this->morphMany(Review::class, 'reviewable');
    }

    /**
     * Scopes
     */
    public function scopeFeatured($query)
    {
        return $query->where('is_featured', true);
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeByCity($query, $city)
    {
        return $query->where('city', $city);
    }

    public function scopeByStars($query, $stars)
    {
        return $query->where('stars', $stars);
    }

    /**
     * Accessors
     */
    public function getFullAddressAttribute(): string
    {
        return trim("{$this->address}, {$this->city}, {$this->country}");
    }

    public function getMainImageAttribute(): ?string
    {
        return $this->images[0] ?? null;
    }

    /**
     * Update rating from reviews
     */
    public function updateRating(): void
    {
        $this->rating = $this->reviews()->avg('rating');
        $this->reviews_count = $this->reviews()->count();
        $this->save();
    }
}
