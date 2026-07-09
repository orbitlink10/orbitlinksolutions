<?php

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
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('name'); // Name of the product
            $table->string('sku')->unique(); // Stock Keeping Unit
            $table->decimal('price', 8, 2); // Price of the product
            $table->decimal('discount', 8, 2)->nullable(); // Discount on the product
            $table->integer('quantity')->nullable();
            $table->string('photo')->nullable(); // Main product image
            $table->string('slug')->unique(); // SEO-friendly URL
            $table->text('description')->nullable(); // Detailed description
            $table->unsignedBigInteger('category_id'); // Foreign key for category
            $table->unsignedBigInteger('sub_category_id')->nullable(); 
            $table->unsignedInteger('stock')->default(0); // Available stock
            $table->boolean('is_active')->default(true); // Active status
            $table->softDeletes(); // Soft delete feature

            // Foreign key constraints
            $table->foreign('category_id')->references('id')->on('categories')->onDelete('cascade');
            $table->foreign('sub_category_id')->references('id')->on('sub_categories')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
