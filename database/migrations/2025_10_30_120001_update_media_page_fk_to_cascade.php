<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Ensure media.page_id uses ON DELETE CASCADE
        Schema::table('media', function (Blueprint $table) {
            try {
                $table->dropForeign(['page_id']);
            } catch (\Throwable $e) {
                // ignore if it doesn't exist or already dropped
            }
        });

        Schema::table('media', function (Blueprint $table) {
            $table->foreign('page_id')
                ->references('id')->on('pages')
                ->onDelete('cascade')
                ->onUpdate('cascade');
        });
    }

    public function down(): void
    {
        Schema::table('media', function (Blueprint $table) {
            try {
                $table->dropForeign(['page_id']);
            } catch (\Throwable $e) {
                // ignore
            }
            // Recreate without explicit cascade (default restrict)
            $table->foreign('page_id')
                ->references('id')->on('pages');
        });
    }
};

