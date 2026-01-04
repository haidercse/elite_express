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
        Schema::create('settings', function (Blueprint $table) {
            $table->id();
            $table->string('group')->default('general');   // e.g. 'booking', 'payment'
            $table->string('key')->unique();              // e.g. 'cancellation_fee_percent'
            $table->string('label');                      // e.g. 'Cancellation Fee (%)'
            $table->text('value')->nullable();            // actual value
            $table->string('type')->default('text');      // 'text','number','select' etc (future use)
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('settings');
    }
};
