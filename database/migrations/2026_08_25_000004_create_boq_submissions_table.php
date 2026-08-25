<?php

use App\Models\User;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (Schema::hasTable('boq_submissions')) {
            return;
        }

        Schema::create('boq_submissions', function (Blueprint $table) {
            $table->id();
            $table->string('reference')->unique();
            $table->foreignIdFor(User::class)->nullable()->constrained()->nullOnDelete();
            $table->string('full_name');
            $table->string('company')->nullable();
            $table->string('phone');
            $table->string('email');
            $table->string('whatsapp_number')->nullable();
            $table->string('project_location');
            $table->string('project_type');
            $table->date('required_delivery_date')->nullable();
            $table->string('budget_range')->nullable();
            $table->text('preferred_brands')->nullable();
            $table->text('requirements')->nullable();
            $table->string('file_path')->nullable();
            $table->string('file_original_name')->nullable();
            $table->string('status')->default('new')->index();
            $table->foreignId('assigned_to')->nullable()->constrained('users')->nullOnDelete();
            $table->text('admin_notes')->nullable();
            $table->string('quotation_path')->nullable();
            $table->timestamp('quoted_at')->nullable();
            $table->timestamps();

            $table->index(['email', 'status']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('boq_submissions');
    }
};
