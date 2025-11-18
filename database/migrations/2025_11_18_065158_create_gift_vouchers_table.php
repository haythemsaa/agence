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
        Schema::create('gift_vouchers', function (Blueprint $table) {
            $table->id();
            $table->string('code', 20)->unique(); // Unique voucher code
            $table->foreignId('purchaser_id')->constrained('users')->onDelete('cascade'); // Who bought it
            $table->string('purchaser_name'); // Name of purchaser
            $table->string('purchaser_email'); // Email of purchaser
            $table->string('recipient_name'); // Name of recipient
            $table->string('recipient_email'); // Email of recipient
            $table->text('personal_message')->nullable(); // Personal message
            $table->decimal('amount', 10, 2); // Voucher value
            $table->string('currency', 3)->default('TND');
            $table->decimal('remaining_balance', 10, 2); // Remaining balance
            $table->enum('status', ['active', 'redeemed', 'expired', 'cancelled'])->default('active');
            $table->timestamp('valid_until'); // Expiration date
            $table->foreignId('redeemed_by')->nullable()->constrained('users')->onDelete('set null'); // User who redeemed
            $table->timestamp('redeemed_at')->nullable(); // When redeemed
            $table->foreignId('booking_id')->nullable(); // Related booking if used
            $table->string('booking_type')->nullable(); // hotel_booking or package_booking
            $table->timestamps();

            $table->index('code');
            $table->index('status');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('gift_vouchers');
    }
};
