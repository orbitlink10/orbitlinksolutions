<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('coupons', function (Blueprint $table) {
            $table->id();
            $table->string('code')->unique();
            $table->string('description')->nullable();
            $table->string('discount_type');
            $table->decimal('discount_value', 12, 2);
            $table->boolean('is_active')->default(true)->index();
            $table->unsignedInteger('usage_limit')->nullable()->default(1);
            $table->unsignedInteger('used_count')->default(0);
            $table->dateTime('expires_at')->nullable()->index();
            $table->string('source')->default('manual')->index();
            $table->foreignId('football_match_id')->nullable()->constrained('football_matches')->nullOnDelete();
            $table->foreignId('created_by')->nullable()->constrained('users')->nullOnDelete();
            $table->foreignId('redeemed_by_user_id')->nullable()->constrained('users')->nullOnDelete();
            $table->unsignedBigInteger('redeemed_order_id')->nullable()->index();
            $table->dateTime('redeemed_at')->nullable();
            $table->timestamps();

            $table->index(['source', 'football_match_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('coupons');
    }
};
