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
        Schema::table('users', function (Blueprint $table) {
            $table->string('referral_code', 10)->unique()->nullable()->after('remember_token');
            $table->foreignId('referred_by_id')->nullable()->constrained('users')->nullOnDelete()->after('referral_code');
            $table->integer('referral_count')->default(0)->after('referred_by_id');
            $table->decimal('referral_earnings', 10, 2)->default(0)->after('referral_count');
            $table->timestamp('referral_reward_claimed_at')->nullable()->after('referral_earnings');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropForeign(['referred_by_id']);
            $table->dropColumn([
                'referral_code',
                'referred_by_id',
                'referral_count',
                'referral_earnings',
                'referral_reward_claimed_at'
            ]);
        });
    }
};
