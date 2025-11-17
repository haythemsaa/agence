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
        Schema::create('payments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');

            // Type de réservation
            $table->string('booking_type'); // hotel_booking, package_booking
            $table->unsignedBigInteger('booking_id');

            // Montant
            $table->decimal('amount', 10, 2);
            $table->string('currency')->default('TND');

            // Méthode de paiement
            $table->enum('payment_method', ['stripe', 'paypal', 'flouci', 'bank_transfer', 'cash'])->default('stripe');

            // Transaction details
            $table->string('transaction_id')->nullable()->unique();
            $table->string('payment_intent_id')->nullable(); // Stripe
            $table->string('payer_id')->nullable(); // PayPal

            // Status
            $table->enum('status', ['pending', 'processing', 'completed', 'failed', 'refunded', 'cancelled'])->default('pending');

            // Metadata
            $table->json('payment_metadata')->nullable();
            $table->text('failure_reason')->nullable();
            $table->timestamp('paid_at')->nullable();
            $table->timestamp('refunded_at')->nullable();

            // Refund
            $table->decimal('refund_amount', 10, 2)->nullable();
            $table->string('refund_transaction_id')->nullable();
            $table->text('refund_reason')->nullable();

            $table->timestamps();

            // Index
            $table->index(['booking_type', 'booking_id']);
            $table->index('status');
            $table->index('payment_method');
            $table->index('created_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payments');
    }
};
