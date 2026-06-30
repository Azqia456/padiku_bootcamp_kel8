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
        Schema::table('fertilizer_schedules', function (Blueprint $table) {
            $table->string('priority')->default('normal')->after('status'); // Prioritas: normal, high, low
            $table->string('delivery_method')->default('delivered')->after('priority'); // Metode pengiriman: delivered, pickup, kios
            $table->string('officer_in_charge')->nullable()->after('delivery_method'); // Petugas
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('fertilizer_schedules', function (Blueprint $table) {
            $table->dropColumn(['priority', 'delivery_method', 'officer_in_charge']);
        });
    }
};
