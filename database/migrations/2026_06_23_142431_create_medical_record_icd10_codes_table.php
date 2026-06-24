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
        Schema::create('medical_record_icd10_codes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('medical_record_id')->constrained()->cascadeOnDelete();
            $table->foreignId('icd10_code_id')->constrained()->cascadeOnDelete();
            $table->enum('diagnosis_type',['primary','secondary']);
            $table->unique(['medical_record_id','icd10_code_id',], 'mr_icd_unique');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('medical_record_icd10_codes');
    }
};
