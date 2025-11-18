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
        // Add flash sale fields to hotels
        Schema::table('hotels', function (Blueprint $table) {
            $table->boolean('is_flash_sale')->default(false)->after('is_featured');
            $table->decimal('flash_sale_price', 10, 2)->nullable()->after('is_flash_sale');
            $table->integer('flash_sale_discount_percent')->nullable()->after('flash_sale_price');
            $table->timestamp('flash_sale_ends_at')->nullable()->after('flash_sale_discount_percent');
        });

        // Add flash sale fields to travel_packages
        Schema::table('travel_packages', function (Blueprint $table) {
            $table->boolean('is_flash_sale')->default(false)->after('is_featured');
            $table->decimal('flash_sale_price_adult', 10, 2)->nullable()->after('is_flash_sale');
            $table->decimal('flash_sale_price_child', 10, 2)->nullable()->after('flash_sale_price_adult');
            $table->integer('flash_sale_discount_percent')->nullable()->after('flash_sale_price_child');
            $table->timestamp('flash_sale_ends_at')->nullable()->after('flash_sale_discount_percent');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('hotels', function (Blueprint $table) {
            $table->dropColumn(['is_flash_sale', 'flash_sale_price', 'flash_sale_discount_percent', 'flash_sale_ends_at']);
        });

        Schema::table('travel_packages', function (Blueprint $table) {
            $table->dropColumn(['is_flash_sale', 'flash_sale_price_adult', 'flash_sale_price_child', 'flash_sale_discount_percent', 'flash_sale_ends_at']);
        });
    }
};
