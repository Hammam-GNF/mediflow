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
        Schema::table('registrations', function (Blueprint $table) {
            $table->string('satusehat_encounter_id')->nullable();
            $table->enum(
                'satusehat_sync_status',
                [
                    'pending',
                    'success',
                    'failed'
                ]
            )->nullable();
            $table->timestamp('satusehat_synced_at')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('registrations', function (Blueprint $table) {
            //
        });
    }
};
