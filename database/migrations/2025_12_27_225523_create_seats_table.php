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
        Schema::create('seats', function (Blueprint $table) {
            $table->id();
            $table->foreignId('vehicle_id')->constrained()->cascadeOnDelete();
            $table->string('seat_number'); // A1, A2, B1...
            $table->enum('seat_type', ['front', 'middle', 'back', 'window', 'driver'])->default('middle');
            $table->decimal('base_fare_multiplier', 5, 2)->default(1.00);
            $table->boolean('is_reserved')->default(false);
            $table->integer('position_row')->nullable();
            $table->integer('position_column')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('seats');
    }
};
