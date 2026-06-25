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
        Schema::create('satusehat_sync_logs', function (Blueprint $table) {
            $table->id();
            $table->string('resource_type');
            $table->unsignedBigInteger('resource_id');
            $table->enum(
                'status',
                [
                    'success',
                    'failed'
                ]
            );
            $table->longText('payload')->nullable();
            $table->longText('response')->nullable();
            $table->text('error_message')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('satusehat_sync_logs');
    }
};
