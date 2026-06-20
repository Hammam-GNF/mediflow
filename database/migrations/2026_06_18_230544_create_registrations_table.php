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
        Schema::create('registrations', function (Blueprint $table) {
            $table->id();
            $table->string('registration_number')->unique();
            $table->foreignId('patient_id')->constrained()->cascadeOnUpdate()->restrictOnDelete();
            $table->foreignId('doctor_id')->constrained()->cascadeOnUpdate()->restrictOnDelete();
            $table->foreignId('polyclinic_id')->constrained()->cascadeOnUpdate()->restrictOnDelete();
            $table->dateTime('registration_date');
            $table->text('complaint')->nullable();
            $table->enum('status', ['registered', 'completed', 'cancelled'])->default('registered');
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('registrations');
    }
};
