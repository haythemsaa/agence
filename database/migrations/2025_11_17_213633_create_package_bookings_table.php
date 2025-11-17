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
        Schema::create('package_bookings', function (Blueprint $table) {
            $table->id();
            $table->string('booking_reference')->unique();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('travel_package_id')->constrained()->onDelete('cascade');

            // Date de départ
            $table->date('departure_date');
            $table->date('return_date')->nullable();

            // Participants
            $table->integer('nb_adults');
            $table->integer('nb_children')->default(0);
            $table->integer('nb_infants')->default(0);
            $table->json('participants'); // Détails de chaque participant

            // Contact principal
            $table->string('contact_first_name');
            $table->string('contact_last_name');
            $table->string('contact_email');
            $table->string('contact_phone');

            // Tarification
            $table->decimal('adults_price', 10, 2);
            $table->decimal('children_price', 10, 2)->default(0);
            $table->decimal('supplements', 10, 2)->default(0);
            $table->decimal('discount', 10, 2)->default(0);
            $table->decimal('total_price', 10, 2);
            $table->string('currency')->default('TND');

            // Paiement échelonné
            $table->boolean('has_installment_plan')->default(false);
            $table->json('installment_plan')->nullable();
            $table->decimal('paid_amount', 10, 2)->default(0);
            $table->decimal('remaining_amount', 10, 2)->default(0);

            // Options
            $table->boolean('has_travel_insurance')->default(false);
            $table->text('special_requests')->nullable();

            // Status
            $table->enum('status', ['pending', 'confirmed', 'paid', 'partially_paid', 'cancelled', 'completed'])->default('pending');
            $table->text('cancellation_reason')->nullable();
            $table->timestamp('cancelled_at')->nullable();

            // Documents
            $table->string('convocation_document')->nullable();
            $table->string('voucher_document')->nullable();

            $table->timestamps();

            // Index
            $table->index('status');
            $table->index('departure_date');
            $table->index('created_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('package_bookings');
    }
};
