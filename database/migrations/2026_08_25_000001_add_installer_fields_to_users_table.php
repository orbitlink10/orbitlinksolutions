<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (! Schema::hasTable('users')) {
            return;
        }

        Schema::table('users', function (Blueprint $table) {
            if (! Schema::hasColumn('users', 'installer_status')) {
                $table->string('installer_status')->nullable()->after('active_status');
            }

            if (! Schema::hasColumn('users', 'installer_discount_percent')) {
                $table->decimal('installer_discount_percent', 5, 2)->nullable()->after('installer_status');
            }

            if (! Schema::hasColumn('users', 'installer_approved_at')) {
                $table->timestamp('installer_approved_at')->nullable()->after('installer_discount_percent');
            }
        });
    }

    public function down(): void
    {
        if (! Schema::hasTable('users')) {
            return;
        }

        Schema::table('users', function (Blueprint $table) {
            foreach (['installer_approved_at', 'installer_discount_percent', 'installer_status'] as $column) {
                if (Schema::hasColumn('users', $column)) {
                    $table->dropColumn($column);
                }
            }
        });
    }
};
