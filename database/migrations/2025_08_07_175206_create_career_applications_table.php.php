<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCareerApplicationsTable extends Migration
{
    public function up()
    {
        Schema::create('career_applications', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email');
            $table->enum('position', [
                'Satellite Installation Technician',
                'Customer Support Specialist',
                'Digital Marketer'
            ]);
            $table->string('resume_path');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('career_applications');
    }
}
