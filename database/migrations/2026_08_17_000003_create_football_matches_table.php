<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('football_matches', function (Blueprint $table) {
            $table->id();
            $table->string('home_team');
            $table->string('away_team');
            $table->string('home_abbreviation', 2);
            $table->string('away_abbreviation', 2);
            $table->string('competition')->nullable();
            $table->date('match_date');
            $table->time('kickoff_time')->nullable();
            $table->dateTime('prediction_closes_at')->index();
            $table->string('status')->default('upcoming')->index();
            $table->unsignedTinyInteger('home_score')->nullable();
            $table->unsignedTinyInteger('away_score')->nullable();
            $table->boolean('is_published')->default(false)->index();
            $table->string('coupon_discount_type')->default('percentage');
            $table->decimal('coupon_discount_value', 12, 2);
            $table->string('coupon_description')->nullable();
            $table->foreignId('created_by')->nullable()->constrained('users')->nullOnDelete();
            $table->dateTime('result_published_at')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('football_matches');
    }
};
