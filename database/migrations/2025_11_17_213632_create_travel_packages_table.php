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
        Schema::create('travel_packages', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('slug')->unique();
            $table->enum('type', ['circuit', 'sejour', 'omra', 'international']); // Type de voyage
            $table->text('short_description');
            $table->longText('description');
            $table->json('itinerary'); // Programme jour par jour
            $table->integer('duration_days');
            $table->integer('duration_nights')->nullable();

            // Destinations
            $table->json('destinations'); // Villes/pays visités
            $table->string('departure_city')->default('Tunis');

            // Tarification
            $table->decimal('price_adult', 10, 2);
            $table->decimal('price_child', 10, 2)->nullable();
            $table->decimal('single_supplement', 10, 2)->nullable();
            $table->string('currency')->default('TND');

            // Inclus/Non inclus
            $table->json('included')->nullable();
            $table->json('not_included')->nullable();

            // Hébergement
            $table->string('accommodation_type')->nullable(); // Hotel, Riad, etc.
            $table->integer('accommodation_stars')->nullable();

            // Transport
            $table->string('transport_type')->nullable(); // Bus, Avion, Bateau

            // Disponibilité
            $table->json('departure_dates')->nullable(); // Dates de départ disponibles
            $table->integer('max_participants')->default(40);
            $table->integer('min_participants')->default(10);

            // Media
            $table->string('featured_image')->nullable();
            $table->json('gallery')->nullable();

            // SEO
            $table->string('meta_title')->nullable();
            $table->text('meta_description')->nullable();
            $table->string('meta_keywords')->nullable();

            // Status
            $table->boolean('is_featured')->default(false);
            $table->boolean('is_active')->default(true);
            $table->decimal('rating', 3, 2)->nullable();
            $table->integer('reviews_count')->default(0);
            $table->integer('bookings_count')->default(0);

            $table->timestamps();

            // Index
            $table->index('type');
            $table->index('is_active');
            $table->index('is_featured');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('travel_packages');
    }
};
