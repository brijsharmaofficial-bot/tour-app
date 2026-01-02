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
        Schema::create('vehicles', function (Blueprint $table) {
            $table->id();
            $table->foreignId('driver_id')->constrained('drivers_profiles')->onDelete('cascade');
            $table->enum('type', ['sedan', 'suv', 'van', 'hatchback']);
            $table->string('brand');
            $table->string('model');
            $table->string('color')->nullable();
            $table->integer('year');
            $table->string('plate_number')->unique();
            $table->string('document_url')->nullable();
            $table->enum('status', ['active', 'maintenance', 'inactive'])->default('active');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('vehicles');
    }
};
