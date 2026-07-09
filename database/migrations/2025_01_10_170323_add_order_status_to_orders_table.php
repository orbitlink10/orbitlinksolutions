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
    Schema::table('orders', function (Blueprint $table) {
        $table->enum('order_status', [
            'pending',
            'processing',
            'shipped',
            'delivered',
            'completed',
            'canceled',
            'returned',
            'refunded'
        ])->default('pending');
    });
}

public function down()
{
    Schema::table('orders', function (Blueprint $table) {
        $table->dropColumn('order_status');
    });
}

};
