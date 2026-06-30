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
        Schema::table('plantings', function (Blueprint $table) {
            // Hapus kolom status lama
            $table->dropColumn('status');
        });

        Schema::table('plantings', function (Blueprint $table) {
            // Tambahkan kolom status baru sebagai varchar
            $table->string('status', 50)->default('persiapan')->after('rice_variety');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('plantings', function (Blueprint $table) {
            $table->dropColumn('status');
        });

        Schema::table('plantings', function (Blueprint $table) {
            $table->enum('status', ['planned', 'growing', 'harvested'])->default('planned')->after('rice_variety');
        });
    }
};
