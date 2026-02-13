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
        Schema::create('courier_job_applications', function (Blueprint $table) {
            $table->id();
            $table->string('fullName');
            $table->string('email')->unique();
            $table->string('phone');
            $table->date('dob');
            $table->text('address');
            $table->string('vehicleType');
            $table->string('licenseNumber');
            $table->date('licenseExpiry');
            $table->string('nationalId');
            $table->json('workingDays');
            $table->time('startTime');
            $table->time('endTime');
            $table->text('experience')->nullable();
            $table->string('reference');
            $table->string('referenceContact');
            $table->string('profilePicture')->nullable();
            $table->string('resume')->nullable();
            $table->tinyInteger('status')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('courier_job_applications');
    }
};
