<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('football_coupon_entitlements', function (Blueprint $table) {
            $table->id();
            $table->foreignId('football_match_id')->constrained()->cascadeOnDelete();
            $table->foreignId('coupon_id')->constrained()->cascadeOnDelete();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->foreignId('order_id')->nullable()->constrained()->nullOnDelete();
            $table->dateTime('redeemed_at')->nullable();
            $table->timestamps();

            $table->unique(['user_id', 'football_match_id', 'coupon_id'], 'football_entitlement_unique');
            $table->index(['coupon_id', 'user_id', 'redeemed_at'], 'football_entitlement_redemption_index');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('football_coupon_entitlements');
    }
};
