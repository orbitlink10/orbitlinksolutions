<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (! Schema::hasTable('products')) {
            return;
        }

        Schema::table('products', function (Blueprint $table) {
            if (! Schema::hasColumn('products', 'brand_name')) {
                $table->string('brand_name')->nullable()->after('name');
            }

            if (! Schema::hasColumn('products', 'model_number')) {
                $table->string('model_number')->nullable()->after('brand_name');
            }

            if (! Schema::hasColumn('products', 'key_technical_feature')) {
                $table->string('key_technical_feature')->nullable()->after('model_number');
            }

            if (! Schema::hasColumn('products', 'best_for_label')) {
                $table->string('best_for_label')->nullable()->after('key_technical_feature');
            }

            if (! Schema::hasColumn('products', 'stock_status')) {
                $table->string('stock_status')->nullable()->after('stock');
            }

            if (! Schema::hasColumn('products', 'installer_price')) {
                $table->decimal('installer_price', 12, 2)->nullable()->after('marked_price');
            }

            if (! Schema::hasColumn('products', 'installer_discount_percent')) {
                $table->decimal('installer_discount_percent', 5, 2)->nullable()->after('installer_price');
            }

            if (! Schema::hasColumn('products', 'installer_price_tiers')) {
                $table->json('installer_price_tiers')->nullable()->after('installer_discount_percent');
            }

            if (! Schema::hasColumn('products', 'popular_with_installers')) {
                $table->boolean('popular_with_installers')->default(false)->after('installer_price_tiers');
            }

            if (! Schema::hasColumn('products', 'installer_deal_label')) {
                $table->string('installer_deal_label')->nullable()->after('popular_with_installers');
            }
        });
    }

    public function down(): void
    {
        if (! Schema::hasTable('products')) {
            return;
        }

        Schema::table('products', function (Blueprint $table) {
            foreach ([
                'installer_deal_label',
                'popular_with_installers',
                'installer_price_tiers',
                'installer_discount_percent',
                'installer_price',
                'stock_status',
                'best_for_label',
                'key_technical_feature',
                'model_number',
                'brand_name',
            ] as $column) {
                if (Schema::hasColumn('products', $column)) {
                    $table->dropColumn($column);
                }
            }
        });
    }
};
