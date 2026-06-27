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
        Schema::table('medical_records', function (Blueprint $table) {
            $table->string('satusehat_condition_id')->nullable();
            $table->string('satusehat_observation_id')->nullable();
            $table->string('satusehat_procedure_id')->nullable();
            $table->string('satusehat_composition_id')->nullable();
            $table->timestamp('satusehat_bundle_synced_at')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('medical_records', function (Blueprint $table) {
            $table->dropColumn([
                'satusehat_condition_id',
                'satusehat_observation_id',
                'satusehat_procedure_id',
                'satusehat_composition_id',
                'satusehat_bundle_synced_at',
            ]);
        });
    }
};
