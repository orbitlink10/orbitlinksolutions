<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (! Schema::hasTable('posts')) {
            Schema::create('posts', function (Blueprint $table) {
                $table->id();
                $table->string('title');
                $table->text('description')->nullable();
                $table->string('user_id')->nullable();
                $table->decimal('price', 8, 2)->nullable();
                $table->string('photo')->nullable();
                $table->string('slug')->nullable()->unique();
                $table->unsignedBigInteger('category_id')->nullable();
                $table->unsignedBigInteger('sub_category_id')->nullable();
                $table->string('job_type')->nullable();
                $table->string('location')->nullable();
                $table->string('company_name')->nullable();
                $table->timestamps();
            });

            return;
        }

        $this->renameColumnIfMissing('App\\Models\\Category', 'category_id');
        $this->renameColumnIfMissing('App\\Models\\SubCategory', 'sub_category_id');

        $columns = Schema::getColumnListing('posts');

        Schema::table('posts', function (Blueprint $table) use ($columns) {
            if (! in_array('title', $columns, true)) {
                $table->string('title')->nullable();
            }

            if (! in_array('description', $columns, true)) {
                $table->text('description')->nullable();
            }

            if (! in_array('user_id', $columns, true)) {
                $table->string('user_id')->nullable();
            }

            if (! in_array('price', $columns, true)) {
                $table->decimal('price', 8, 2)->nullable();
            }

            if (! in_array('photo', $columns, true)) {
                $table->string('photo')->nullable();
            }

            if (! in_array('slug', $columns, true)) {
                $table->string('slug')->nullable()->unique();
            }

            if (! in_array('category_id', $columns, true)) {
                $table->unsignedBigInteger('category_id')->nullable();
            }

            if (! in_array('sub_category_id', $columns, true)) {
                $table->unsignedBigInteger('sub_category_id')->nullable();
            }

            if (! in_array('job_type', $columns, true)) {
                $table->string('job_type')->nullable();
            }

            if (! in_array('location', $columns, true)) {
                $table->string('location')->nullable();
            }

            if (! in_array('company_name', $columns, true)) {
                $table->string('company_name')->nullable();
            }
        });

        $this->makeColumnNullable('price', 'DECIMAL(8,2)');
        $this->makeColumnNullable('photo', 'VARCHAR(255)');
        $this->makeColumnNullable('slug', 'VARCHAR(255)');
    }

    public function down(): void
    {
        //
    }

    private function renameColumnIfMissing(string $from, string $to): void
    {
        if (! Schema::hasColumn('posts', $from) || Schema::hasColumn('posts', $to)) {
            return;
        }

        DB::statement(sprintf(
            'ALTER TABLE `posts` CHANGE `%s` `%s` BIGINT UNSIGNED NULL',
            str_replace('`', '``', $from),
            str_replace('`', '``', $to)
        ));
    }

    private function makeColumnNullable(string $column, string $type): void
    {
        if (! Schema::hasColumn('posts', $column)) {
            return;
        }

        DB::statement(sprintf(
            'ALTER TABLE `posts` MODIFY `%s` %s NULL',
            str_replace('`', '``', $column),
            $type
        ));
    }
};
