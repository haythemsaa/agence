<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Review extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'reviewable_type',
        'reviewable_id',
        'rating',
        'comment',
        'cleanliness_rating',
        'comfort_rating',
        'location_rating',
        'service_rating',
        'value_rating',
        'photos',
        'is_published',
        'is_verified',
        'admin_response',
        'admin_responded_at',
        'helpful_count',
        'not_helpful_count',
    ];

    protected function casts(): array
    {
        return [
            'rating' => 'decimal:2',
            'cleanliness_rating' => 'decimal:2',
            'comfort_rating' => 'decimal:2',
            'location_rating' => 'decimal:2',
            'service_rating' => 'decimal:2',
            'value_rating' => 'decimal:2',
            'photos' => 'array',
            'is_published' => 'boolean',
            'is_verified' => 'boolean',
            'admin_responded_at' => 'datetime',
        ];
    }

    /**
     * Relationships
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function reviewable()
    {
        return $this->morphTo();
    }

    /**
     * Scopes
     */
    public function scopePublished($query)
    {
        return $query->where('is_published', true);
    }

    public function scopeVerified($query)
    {
        return $query->where('is_verified', true);
    }

    public function scopeRecent($query)
    {
        return $query->orderBy('created_at', 'desc');
    }

    /**
     * Publish review
     */
    public function publish(): void
    {
        $this->is_published = true;
        $this->save();

        // Update related model rating
        if ($this->reviewable) {
            $this->reviewable->updateRating();
        }
    }

    /**
     * Add admin response
     */
    public function addAdminResponse(string $response): void
    {
        $this->admin_response = $response;
        $this->admin_responded_at = now();
        $this->save();
    }

    /**
     * Mark as helpful
     */
    public function markAsHelpful(): void
    {
        $this->helpful_count++;
        $this->save();
    }

    /**
     * Mark as not helpful
     */
    public function markAsNotHelpful(): void
    {
        $this->not_helpful_count++;
        $this->save();
    }
}
