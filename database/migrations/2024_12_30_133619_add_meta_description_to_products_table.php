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
    Schema::table('products', function (Blueprint $table) {
        $table->text('meta_description')->nullable()->after('description'); // Adjust the position as needed
    });
}

public function down()
{
    Schema::table('products', function (Blueprint $table) {
        $table->dropColumn('meta_description');
    });
}

};
