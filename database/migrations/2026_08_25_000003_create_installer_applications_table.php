<?php

use App\Models\User;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (Schema::hasTable('installer_applications')) {
            return;
        }

        Schema::create('installer_applications', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(User::class)->nullable()->constrained()->nullOnDelete();
            $table->string('full_name');
            $table->string('phone');
            $table->string('email');
            $table->string('company_name');
            $table->string('county');
            $table->string('town');
            $table->string('business_type');
            $table->string('years_in_business')->nullable();
            $table->string('monthly_purchases')->nullable();
            $table->text('main_brands')->nullable();
            $table->text('preferred_categories')->nullable();
            $table->boolean('buys_for_projects')->default(false);
            $table->string('whatsapp_number')->nullable();
            $table->string('business_registration_number')->nullable();
            $table->string('kra_pin')->nullable();
            $table->string('supporting_document_path')->nullable();
            $table->boolean('marketing_consent')->default(false);
            $table->string('status')->default('pending')->index();
            $table->decimal('approved_discount_percent', 5, 2)->nullable();
            $table->text('admin_notes')->nullable();
            $table->foreignId('reviewed_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamp('reviewed_at')->nullable();
            $table->timestamps();

            $table->index(['email', 'status']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('installer_applications');
    }
};
