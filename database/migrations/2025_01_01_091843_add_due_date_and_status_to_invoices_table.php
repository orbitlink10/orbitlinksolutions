<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
public function up()
{
    Schema::table('invoices', function (Blueprint $table) {
        $table->date('due_date')->nullable(); // Add due_date field
        $table->string('status')->default('pending'); // Add status field with default value
    });
}

public function down()
{
    Schema::table('invoices', function (Blueprint $table) {
        $table->dropColumn(['due_date', 'status']); // Rollback columns
    });
}

};
