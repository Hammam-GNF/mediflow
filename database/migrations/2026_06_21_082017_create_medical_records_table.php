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
        Schema::create('medical_records', function (Blueprint $table) {
            $table->id();
             $table->foreignId('registration_id')
                ->unique()
                ->constrained()
                ->cascadeOnDelete();
            $table->text('chief_complaint');
            $table->decimal(
                'height',
                5,
                2
            )->nullable();
            $table->decimal(
                'weight',
                5,
                2
            )->nullable();
            $table->string('blood_pressure')->nullable();
            $table->integer('heart_rate')->nullable();
            $table->decimal(
                'body_temperature',
                4,
                1
            )->nullable();
            $table->integer('respiratory_rate')->nullable();
            $table->text('diagnosis');
            $table->longText('examination_notes')->nullable();
            $table->dateTime('examined_at');
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('medical_records');
    }
};
