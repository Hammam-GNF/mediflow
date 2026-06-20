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
        Schema::create('queues', function (Blueprint $table) {
            $table->id();
            $table->foreignId('registration_id')
                ->unique()
                ->constrained()
                ->cascadeOnUpdate()
                ->restrictOnDelete();
            $table->string('queue_number')->unique();
            $table->dateTime('queue_date');
            $table->enum('status', [
                'waiting',
                'called',
                'in_progress',
                'done',
                'cancelled',
            ])->default('waiting');
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('queues');
    }
};
