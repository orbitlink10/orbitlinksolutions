<?php

use App\Models\Category;
use App\Models\SubCategory;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('posts', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->text('description')->nullable();
            $table->string('user_id')->nullable();
            $table->decimal('price', 8, 2)->nullable();
            $table->string('photo')->nullable();
            $table->string('slug')->nullable()->unique();
            $table->foreignIdFor(Category::class)->nullable();
            $table->foreignIdFor(SubCategory::class)->nullable();
            $table->string('job_type')->nullable();
            $table->string('location')->nullable();
            $table->string('company_name')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('posts');
    }
};
