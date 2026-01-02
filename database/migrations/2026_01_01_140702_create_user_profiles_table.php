<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('user_profiles', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');

            // Basic Info
            $table->string('phone')->nullable();
            $table->date('dob')->nullable();
            $table->string('gender')->nullable();

            // Identity Info
            $table->string('nid_number')->nullable();
            $table->string('passport_number')->nullable();
            $table->string('address')->nullable();

            // Employment Info
            $table->decimal('salary', 10, 2)->nullable();
            $table->string('salary_type')->nullable(); // monthly/hourly
            $table->string('employment_type')->nullable(); // full-time/part-time/contract
            $table->date('joining_date')->nullable();

            // Bank Info
            $table->string('bank_name')->nullable();
            $table->string('bank_account')->nullable();

            // Documents
            $table->string('profile_photo')->nullable();
            $table->string('nid_document')->nullable();
            $table->string('contract_document')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_profiles');
    }
};
