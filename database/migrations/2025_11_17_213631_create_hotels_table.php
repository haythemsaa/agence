<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('hotels', function (Blueprint $table) {
            $table->id();
            $table->string('api_provider')->default('hotelbeds'); // hotelbeds, amadeus, expedia
            $table->string('api_hotel_id')->index();
            $table->string('name');
            $table->string('city');
            $table->string('country')->default('TN');
            $table->string('address')->nullable();
            $table->string('postal_code')->nullable();
            $table->decimal('latitude', 10, 8)->nullable();
            $table->decimal('longitude', 11, 8)->nullable();
            $table->integer('stars')->nullable();
            $table->text('description')->nullable();
            $table->json('amenities')->nullable();
            $table->json('images')->nullable();
            $table->decimal('rating', 3, 2)->nullable();
            $table->integer('reviews_count')->default(0);
            $table->string('phone')->nullable();
            $table->string('email')->nullable();
            $table->string('website')->nullable();
            $table->boolean('is_featured')->default(false);
            $table->boolean('is_active')->default(true);
            $table->timestamps();

            // Index composé pour recherche rapide
            $table->unique(['api_provider', 'api_hotel_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('hotels');
    }
};
