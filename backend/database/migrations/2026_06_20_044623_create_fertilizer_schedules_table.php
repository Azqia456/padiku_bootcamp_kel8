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
        Schema::create('fertilizer_schedules', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('planting_id')->constrained()->onDelete('cascade');
            $table->string('fertilizer_type');
            $table->decimal('amount_kg', 8, 2);
            $table->date('scheduled_date');
            $table->enum('status', ['scheduled', 'applied', 'skipped'])->default('scheduled');
            $table->date('applied_date')->nullable();
            $table->text('notes')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('fertilizer_schedules');
    }
};
