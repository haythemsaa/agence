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
        Schema::create('hotel_bookings', function (Blueprint $table) {
            $table->id();
            $table->string('booking_reference')->unique();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('hotel_id')->nullable()->constrained()->onDelete('set null');

            // Données du séjour
            $table->date('check_in');
            $table->date('check_out');
            $table->integer('nights');
            $table->integer('rooms')->default(1);
            $table->integer('adults');
            $table->integer('children')->default(0);

            // Informations client
            $table->string('guest_first_name');
            $table->string('guest_last_name');
            $table->string('guest_email');
            $table->string('guest_phone');

            // Données hôtel (cache de l'API)
            $table->string('hotel_name');
            $table->string('hotel_city');
            $table->string('hotel_country');
            $table->string('room_type')->nullable();
            $table->string('board_type')->nullable(); // RO, BB, HB, FB, AI

            // Tarification
            $table->decimal('room_price', 10, 2);
            $table->decimal('taxes', 10, 2)->default(0);
            $table->decimal('fees', 10, 2)->default(0);
            $table->decimal('total_price', 10, 2);
            $table->string('currency')->default('TND');

            // API data
            $table->string('api_provider')->default('hotelbeds');
            $table->string('api_booking_id')->nullable();
            $table->string('api_rate_key')->nullable();
            $table->json('api_response')->nullable();

            // Status
            $table->enum('status', ['pending', 'confirmed', 'cancelled', 'completed'])->default('pending');
            $table->text('cancellation_reason')->nullable();
            $table->timestamp('cancelled_at')->nullable();

            // Options
            $table->boolean('has_transfer')->default(false);
            $table->boolean('has_insurance')->default(false);
            $table->text('special_requests')->nullable();

            $table->timestamps();

            // Index
            $table->index('status');
            $table->index('check_in');
            $table->index('created_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('hotel_bookings');
    }
};
