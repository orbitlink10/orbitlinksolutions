<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('football_predictions', function (Blueprint $table) {
            $table->string('prediction_pick', 10)->nullable()->index();
        });
    }

    public function down(): void
    {
        Schema::table('football_predictions', function (Blueprint $table) {
            $table->dropColumn('prediction_pick');
        });
    }
};
