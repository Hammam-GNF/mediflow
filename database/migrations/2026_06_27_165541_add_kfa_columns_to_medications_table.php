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
        Schema::table('medications', function (Blueprint $table) {
            $table->string('kfa_code')->nullable();
            $table->string('kfa_display')->nullable();
            $table->timestamp('kfa_synced_at')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('medications', function (Blueprint $table) {
            $table->dropColumn('kfa_code');
            $table->dropColumn('kfa_display');
            $table->dropColumn('kfa_synced_at');
        });
    }
};
