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
        Schema::create('trips', function (Blueprint $table) {
            $table->id();
            $table->foreignId('route_id')->constrained()->cascadeOnDelete();
            $table->foreignId('vehicle_id')->constrained()->cascadeOnDelete();
            $table->string('trip_code')->nullable()->unique();
            $table->date('date');
            $table->time('departure_time');
            $table->time('arrival_time')->nullable();
            $table->decimal('base_fare', 10, 2);
            $table->enum('status', ['scheduled', 'cancelled', 'completed'])->default('scheduled');
            $table->timestamps();

        });
        ;
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('trips');
    }
};
