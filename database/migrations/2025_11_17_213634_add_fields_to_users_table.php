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
            $table->string('phone')->nullable()->after('email');
            $table->string('role')->default('client')->after('password'); // client, admin
            $table->integer('loyalty_points')->default(0)->after('role');
            $table->string('loyalty_level')->default('bronze')->after('loyalty_points'); // bronze, silver, gold, platinum
            $table->date('birth_date')->nullable()->after('loyalty_level');
            $table->string('gender')->nullable()->after('birth_date'); // M, F
            $table->string('country')->default('TN')->after('gender');
            $table->string('city')->nullable()->after('country');
            $table->string('address')->nullable()->after('city');
            $table->string('postal_code')->nullable()->after('address');
            $table->boolean('newsletter_subscribed')->default(false)->after('postal_code');
            $table->boolean('is_active')->default(true)->after('newsletter_subscribed');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn([
                'phone', 'role', 'loyalty_points', 'loyalty_level',
                'birth_date', 'gender', 'country', 'city', 'address',
                'postal_code', 'newsletter_subscribed', 'is_active'
            ]);
        });
    }
};
