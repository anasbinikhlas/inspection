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
        Schema::create('inspection_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('inspection_id')->constrained()->onDelete('cascade');
            
            // Item Details
            $table->string('category'); // engine_transmission, brakes, etc.
            $table->string('item_name'); // Oil Level, Brake Pads, etc.
            $table->string('item_code')->nullable(); // ENG_001, BRK_001, etc.
            
            // Assessment
            $table->enum('condition', ['excellent', 'good', 'fair', 'poor', 'failed', 'not_applicable']);
            $table->decimal('percentage_rating', 5, 2)->nullable(); // 0-100%
            $table->enum('priority', ['low', 'medium', 'high', 'critical'])->default('low');
            
            // Measurements and Values
            $table->string('measured_value')->nullable(); // "5.2L", "80%", "3mm", etc.
            $table->string('acceptable_range')->nullable(); // "4.5-5.5L", "60-100%", etc.
            $table->boolean('within_spec')->default(true);
            
            // Cost and Recommendations
            $table->decimal('estimated_repair_cost', 8, 2)->nullable();
            $table->text('findings')->nullable(); // What was found during inspection
            $table->text('recommendations')->nullable(); // What should be done
            $table->text('notes')->nullable(); // Additional inspector notes
            
            // Media references
            $table->json('photo_references')->nullable(); // Array of photo IDs related to this item
            
            $table->timestamps();
            
            $table->index(['inspection_id', 'category']);
            $table->index(['condition', 'priority']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('inspection_items');
    }
};