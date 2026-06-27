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
        Schema::table('prescription_items', function (Blueprint $table) {
            $table->string('satusehat_medication_id')->nullable()->after('notes');
            $table->string('satusehat_medication_request_id')->nullable()->after('satusehat_medication_id');
            $table->timestamp('satusehat_synced_at')->nullable()->after('satusehat_medication_request_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('prescription_items', function (Blueprint $table) {
            $table->dropColumn([
                'satusehat_medication_id',
                'satusehat_medication_request_id',
                'satusehat_synced_at',
            ]);
        });
    }
};
