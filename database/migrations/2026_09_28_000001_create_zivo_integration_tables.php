<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('zivo_api_keys', function (Blueprint $table) {
            $table->id();
            $table->string('store_id');
            $table->string('name');
            $table->char('key_hash', 64)->unique();
            $table->timestamp('expires_at')->nullable();
            $table->timestamp('revoked_at')->nullable();
            $table->timestamps();
        });

        Schema::create('zivo_webhook_events', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('store_id');
            // No FK: deletion notifications must survive the product's deletion.
            $table->unsignedBigInteger('product_id');
            $table->string('type');
            $table->longText('payload');
            $table->unsignedInteger('attempts')->default(0);
            $table->timestamp('available_at')->index();
            $table->timestamp('locked_until')->nullable();
            $table->timestamp('delivered_at')->nullable();
            $table->timestamp('failed_at')->nullable();
            $table->string('last_error')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('zivo_webhook_events');
        Schema::dropIfExists('zivo_api_keys');
    }
};
