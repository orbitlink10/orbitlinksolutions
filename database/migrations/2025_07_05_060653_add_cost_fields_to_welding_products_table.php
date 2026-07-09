<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddCostFieldsToWeldingProductsTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('welding_products', function (Blueprint $table) {
            $table->decimal('material_cost', 10, 2)->nullable()->after('id');
            $table->decimal('labour_cost', 10, 2)->nullable()->after('material_cost');
            $table->decimal('total_cost', 10, 2)->nullable()->after('labour_cost');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('welding_products', function (Blueprint $table) {
            $table->dropColumn(['material_cost', 'labour_cost', 'total_cost']);
        });
    }
}
