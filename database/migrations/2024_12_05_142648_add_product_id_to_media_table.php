<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddProductIdToMediaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('media', function (Blueprint $table) {
            // Adding the product_id column
            $table->unsignedBigInteger('product_id')->nullable()->after('id'); // You can adjust the position if needed
            // Optionally, you can add a foreign key if you have a products table
            $table->foreign('product_id')->references('id')->on('products')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('media', function (Blueprint $table) {
            // Dropping the product_id column and foreign key if exists
            $table->dropForeign(['product_id']);
            $table->dropColumn('product_id');
        });
    }
}
