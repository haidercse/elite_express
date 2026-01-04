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
    Schema::create('bookings', function (Blueprint $table) {
        $table->id();

        $table->foreignId('user_id')->nullable()->constrained()->nullOnDelete();
        $table->foreignId('trip_id')->constrained()->cascadeOnDelete();

        // Optional: single seat for now (later multi-seat table add করা যাবে)
        $table->foreignId('seat_id')->nullable()->constrained()->nullOnDelete();

        // Passenger info (important for real booking)
        $table->string('passenger_name')->nullable();
        $table->string('passenger_phone')->nullable();

        $table->decimal('fare', 10, 2)->default(0);
        $table->decimal('total_amount', 10, 2)->default(0);

        $table->enum('status', ['pending', 'confirmed', 'cancelled'])->default('pending');
        $table->enum('payment_status', ['unpaid', 'paid', 'partial'])->default('unpaid');

        $table->string('booking_code')->unique();

        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bookings');
    }
};
