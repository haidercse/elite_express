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
        Schema::create('routes', function (Blueprint $table) {
            $table->id();

            // Basic route info
            $table->string('from_city');
            $table->string('to_city');

            // Optional but very useful
            $table->string('route_code')->unique()->nullable(); // e.g., MD-DHK-01
            $table->string('slug')->unique()->nullable();       // for SEO or URL

            // Distance & duration
            $table->integer('distance_km')->nullable();
            $table->integer('approx_duration_minutes')->nullable();

            // Fare (future trip module)
            $table->decimal('base_fare', 10, 2)->nullable();

            // Pickup & drop points (JSON for flexibility)
            $table->json('pickup_points')->nullable();
            $table->json('drop_points')->nullable();

            // Two-way route support
            $table->boolean('is_two_way')->default(false);

            // Notes
            $table->text('notes')->nullable();

            // Status
            $table->enum('status', ['active', 'inactive'])->default('active');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('routes');
    }
};
