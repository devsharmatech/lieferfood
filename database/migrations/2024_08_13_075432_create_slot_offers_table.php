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
        Schema::create('slot_offers', function (Blueprint $table) {
            $table->id();
            $table->foreignId('slot_id')->constrained('slots','id')->onDelete('cascade');
            $table->foreignId('vendor_id')->constrained('users','id')->onDelete('cascade');
            $table->string('title')->nullable();
            $table->string('description')->nullable();
            $table->string('image')->nullable();
            $table->enum('discount_type',['fixed','percentage'])->default('fixed');
            $table->string('discount')->default(0);
            $table->string('upto_price')->default(0);
            $table->string('start_date')->nullable();
            $table->string('end_date')->nullable();
            $table->tinyInteger('status')->default(1);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('slot_offers');
    }
};
