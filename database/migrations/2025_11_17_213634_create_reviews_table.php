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
        Schema::create('reviews', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');

            // Polymorphic relationship
            $table->string('reviewable_type'); // Hotel, TravelPackage
            $table->unsignedBigInteger('reviewable_id');

            // Note et commentaire
            $table->decimal('rating', 3, 2); // 0-10
            $table->text('comment');

            // Critères détaillés (pour hôtels)
            $table->decimal('cleanliness_rating', 3, 2)->nullable();
            $table->decimal('comfort_rating', 3, 2)->nullable();
            $table->decimal('location_rating', 3, 2)->nullable();
            $table->decimal('service_rating', 3, 2)->nullable();
            $table->decimal('value_rating', 3, 2)->nullable();

            // Media
            $table->json('photos')->nullable();

            // Modération
            $table->boolean('is_published')->default(false);
            $table->boolean('is_verified')->default(false); // Client a vraiment réservé
            $table->text('admin_response')->nullable();
            $table->timestamp('admin_responded_at')->nullable();

            // Stats
            $table->integer('helpful_count')->default(0);
            $table->integer('not_helpful_count')->default(0);

            $table->timestamps();

            // Index
            $table->index(['reviewable_type', 'reviewable_id']);
            $table->index('is_published');
            $table->index('rating');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reviews');
    }
};
