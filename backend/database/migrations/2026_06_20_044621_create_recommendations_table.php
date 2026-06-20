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
        Schema::create('recommendations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('planting_id')->nullable()->constrained()->onDelete('set null');
            $table->string('category'); // e.g., 'fertilizer', 'pest_control', 'irrigation'
            $table->string('title');
            $table->text('description');
            $table->text('action_steps');
            $table->enum('priority', ['low', 'medium', 'high'])->default('medium');
            $table->boolean('is_applied')->default(false);
            $table->timestamp('applied_at')->nullable();
            $table->date('valid_until')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('recommendations');
    }
};
