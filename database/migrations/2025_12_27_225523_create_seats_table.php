<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('seats', function (Blueprint $table) {
            $table->id();

            $table->foreignId('vehicle_id')->constrained()->cascadeOnDelete();

            $table->string('seat_number'); // S1, S2, A1, B2 etc.
            $table->string('seat_label')->nullable(); // A1, A2, B1, B2

            $table->enum('seat_type', ['front', 'middle', 'back', 'window', 'aisle', 'driver'])
                ->default('middle');

            $table->enum('seat_category', ['vip', 'regular', 'economy'])
                ->default('regular');

            $table->boolean('is_window_seat')->default(false);
            $table->boolean('is_aisle_seat')->default(false);
            $table->boolean('is_near_door')->default(false);

            $table->decimal('base_fare_multiplier', 5, 2)->default(1.00);
            $table->decimal('seat_fare_override', 10, 2)->nullable();

            $table->integer('position_row')->nullable();
            $table->integer('position_column')->nullable();

            $table->string('seat_group')->nullable(); // left, right, back, driver

            $table->boolean('is_reserved')->default(false);

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
