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
        Schema::table('invoices', function (Blueprint $table) {
            $table->decimal(
                'subtotal_amount',
                12,
                2
            )->default(0)->after('registration_id');

            $table->decimal(
                'discount_amount',
                12,
                2
            )->default(0)->after('subtotal_amount');

            $table->decimal(
                'tax_amount',
                12,
                2
            )->default(0)->after('discount_amount');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('invoices', function (Blueprint $table) {
            $table->dropColumn('subtotal_amount');
            $table->dropColumn('discount_amount');
            $table->dropColumn('tax_amount');
        });
    }
};
