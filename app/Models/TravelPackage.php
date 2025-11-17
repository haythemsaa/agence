<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Str;

class TravelPackage extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'slug',
        'type',
        'short_description',
        'description',
        'itinerary',
        'duration_days',
        'duration_nights',
        'destinations',
        'departure_city',
        'price_adult',
        'price_child',
        'single_supplement',
        'currency',
        'included',
        'not_included',
        'accommodation_type',
        'accommodation_stars',
        'transport_type',
        'departure_dates',
        'max_participants',
        'min_participants',
        'featured_image',
        'gallery',
        'meta_title',
        'meta_description',
        'meta_keywords',
        'is_featured',
        'is_active',
        'rating',
        'reviews_count',
        'bookings_count',
    ];

    protected function casts(): array
    {
        return [
            'itinerary' => 'array',
            'destinations' => 'array',
            'price_adult' => 'decimal:2',
            'price_child' => 'decimal:2',
            'single_supplement' => 'decimal:2',
            'included' => 'array',
            'not_included' => 'array',
            'departure_dates' => 'array',
            'gallery' => 'array',
            'is_featured' => 'boolean',
            'is_active' => 'boolean',
            'rating' => 'decimal:2',
        ];
    }

    /**
     * Boot method to auto-generate slug
     */
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($package) {
            if (empty($package->slug)) {
                $package->slug = Str::slug($package->title);
            }
        });
    }

    /**
     * Relationships
     */
    public function bookings()
    {
        return $this->hasMany(PackageBooking::class);
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

    public function scopeByType($query, $type)
    {
        return $query->where('type', $type);
    }

    /**
     * Get available places for a specific departure date
     */
    public function getAvailablePlaces(string $date): int
    {
        $bookedPlaces = $this->bookings()
            ->where('departure_date', $date)
            ->whereIn('status', ['confirmed', 'paid', 'partially_paid'])
            ->sum('nb_adults');

        return max(0, $this->max_participants - $bookedPlaces);
    }

    /**
     * Check if package is available for a date
     */
    public function isAvailableForDate(string $date): bool
    {
        return $this->getAvailablePlaces($date) >= $this->min_participants;
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
