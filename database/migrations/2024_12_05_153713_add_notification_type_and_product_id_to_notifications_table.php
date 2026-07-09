<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddNotificationTypeAndProductIdToNotificationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('notifications', function (Blueprint $table) {
            $table->string('notification_type')->nullable()->after('id');
            $table->unsignedBigInteger('product_id')->nullable()->after('notification_type');

            // If you have a products table and want a foreign key relationship:
            // $table->foreign('product_id')->references('id')->on('products')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('notifications', function (Blueprint $table) {
            if (Schema::hasColumn('notifications', 'product_id')) {
                $table->dropForeign(['product_id']); // Remove foreign key if added
                $table->dropColumn('product_id');
            }
            if (Schema::hasColumn('notifications', 'notification_type')) {
                $table->dropColumn('notification_type');
            }
        });
    }
}
