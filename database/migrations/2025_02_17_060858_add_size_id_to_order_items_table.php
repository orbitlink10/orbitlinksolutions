<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddSizeIdToOrderItemsTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        if (! Schema::hasTable('order_items') || Schema::hasColumn('order_items', 'size_id')) {
            return;
        }

        Schema::table('order_items', function (Blueprint $table) {
            $table->unsignedBigInteger('size_id')->nullable()->after('product_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        if (! Schema::hasTable('order_items') || ! Schema::hasColumn('order_items', 'size_id')) {
            return;
        }

        Schema::table('order_items', function (Blueprint $table) {
            $table->dropColumn('size_id');
        });
    }
}
