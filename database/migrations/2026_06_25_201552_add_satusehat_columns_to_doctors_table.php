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
        Schema::table('doctors', function (Blueprint $table) {
            $table->string('nik', 16)->nullable()->after('doctor_code');
            $table->string('satusehat_practitioner_id')->nullable()->after('sip_number');
            $table->timestamp('satusehat_synced_at')->nullable()->after('satusehat_practitioner_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('doctors', function (Blueprint $table) {
            $table->dropColumn([
                'nik',
                'satusehat_practitioner_id',
                'satusehat_synced_at',
            ]);
        });
    }
};
