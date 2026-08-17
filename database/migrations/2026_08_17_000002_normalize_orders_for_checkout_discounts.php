<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (! Schema::hasTable('orders')) {
            return;
        }

        Schema::table('orders', function (Blueprint $table) {
            if (! Schema::hasColumn('orders', 'order_reference')) {
                $table->string('order_reference')->nullable()->unique()->after('id');
            }

            if (! Schema::hasColumn('orders', 'customer_first_name')) {
                $table->string('customer_first_name')->nullable()->after('order_reference');
            }

            if (! Schema::hasColumn('orders', 'customer_last_name')) {
                $table->string('customer_last_name')->nullable()->after('customer_first_name');
            }

            if (! Schema::hasColumn('orders', 'customer_email')) {
                $table->string('customer_email')->nullable()->after('customer_last_name');
            }

            if (! Schema::hasColumn('orders', 'customer_phone')) {
                $table->string('customer_phone')->nullable()->after('customer_email');
            }

            if (! Schema::hasColumn('orders', 'user_id')) {
                $table->unsignedBigInteger('user_id')->nullable()->index()->after('customer_phone');
            }

            if (! Schema::hasColumn('orders', 'shipping_address')) {
                $table->text('shipping_address')->nullable()->after('user_id');
            }

            if (! Schema::hasColumn('orders', 'subtotal')) {
                $table->decimal('subtotal', 12, 2)->default(0)->after('shipping_address');
            }

            if (! Schema::hasColumn('orders', 'shipping_cost')) {
                $table->decimal('shipping_cost', 12, 2)->default(0)->after('subtotal');
            }

            if (! Schema::hasColumn('orders', 'total_amount')) {
                $table->decimal('total_amount', 12, 2)->default(0)->after('shipping_cost');
            }

            if (! Schema::hasColumn('orders', 'product_id')) {
                $table->unsignedBigInteger('product_id')->nullable()->index()->after('total_amount');
            }

            if (! Schema::hasColumn('orders', 'status')) {
                $table->string('status')->default('pending')->after('product_id');
            }

            if (! Schema::hasColumn('orders', 'company_name')) {
                $table->string('company_name')->nullable()->after('status');
            }

            if (! Schema::hasColumn('orders', 'county_id')) {
                $table->unsignedBigInteger('county_id')->nullable()->index()->after('company_name');
            }

            if (! Schema::hasColumn('orders', 'address')) {
                $table->text('address')->nullable()->after('county_id');
            }

            if (! Schema::hasColumn('orders', 'coupon_id')) {
                $table->unsignedBigInteger('coupon_id')->nullable()->index()->after('address');
            }

            if (! Schema::hasColumn('orders', 'coupon_code')) {
                $table->string('coupon_code')->nullable()->after('coupon_id');
            }

            if (! Schema::hasColumn('orders', 'discount_amount')) {
                $table->decimal('discount_amount', 12, 2)->default(0)->after('coupon_code');
            }

            if (! Schema::hasColumn('orders', 'subtotal_before_discount')) {
                $table->decimal('subtotal_before_discount', 12, 2)->nullable()->after('discount_amount');
            }

            if (! Schema::hasColumn('orders', 'total_after_discount')) {
                $table->decimal('total_after_discount', 12, 2)->nullable()->after('subtotal_before_discount');
            }
        });
    }

    public function down(): void
    {
        if (! Schema::hasTable('orders')) {
            return;
        }

        Schema::table('orders', function (Blueprint $table) {
            foreach ([
                'total_after_discount',
                'subtotal_before_discount',
                'discount_amount',
                'coupon_code',
                'coupon_id',
            ] as $column) {
                if (Schema::hasColumn('orders', $column)) {
                    $table->dropColumn($column);
                }
            }
        });
    }
};
