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
        Schema::create('pest_reports', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('planting_id')->nullable()->constrained()->onDelete('set null');
            $table->string('pest_type');
            $table->text('description');
            $table->decimal('latitude', 10, 8);
            $table->decimal('longitude', 11, 8);
            $table->enum('severity', ['low', 'medium', 'high'])->default('medium');
            $table->enum('status', ['reported', 'in_progress', 'resolved'])->default('reported');
            $table->date('report_date');
            $table->text('action_taken')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pest_reports');
    }
};
