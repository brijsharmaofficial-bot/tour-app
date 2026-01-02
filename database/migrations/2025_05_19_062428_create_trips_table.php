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
        Schema::create('trips', function (Blueprint $table) {
            $table->id();
            $table->foreignId('customer_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('driver_id')->nullable()->constrained('users')->onDelete('set null');
            $table->foreignId('vehicle_id')->nullable()->constrained('vehicles');
            $table->enum('trip_type', ['local', 'outstation', 'airport']);
            $table->enum('status', ['pending', 'confirmed', 'in_progress', 'completed', 'cancelled'])->default('pending');
            $table->string('pickup_location');
            $table->string('drop_location');
            $table->dateTime('pickup_datetime');
            $table->dateTime('drop_datetime')->nullable();
            $table->decimal('total_km', 8, 2)->nullable();
            $table->decimal('base_price', 10, 2);
            $table->decimal('final_price', 10, 2)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('trips');
    }
};
