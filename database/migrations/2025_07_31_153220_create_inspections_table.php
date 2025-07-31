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
        Schema::create('inspections', function (Blueprint $table) {
            $table->id();
            $table->string('inspection_number')->unique(); // INS-2025-001
            $table->foreignId('appointment_id')->constrained()->onDelete('cascade');
            $table->foreignId('inspector_id')->constrained()->onDelete('cascade');
            
            // Overall Inspection Results
            $table->decimal('overall_score', 5, 2)->nullable(); // Out of 100
            $table->enum('overall_condition', ['excellent', 'good', 'fair', 'poor', 'needs_attention']);
            $table->enum('recommendation', ['buy', 'negotiate', 'avoid', 'minor_repairs', 'major_repairs']);
            
            // Individual Section Scores (13-point inspection)
            $table->decimal('engine_transmission_score', 5, 2)->nullable();
            $table->decimal('brakes_score', 5, 2)->nullable();
            $table->decimal('suspension_steering_score', 5, 2)->nullable();
            $table->decimal('interior_score', 5, 2)->nullable();
            $table->decimal('ac_heater_score', 5, 2)->nullable();
            $table->decimal('electrical_score', 5, 2)->nullable();
            $table->decimal('exterior_body_score', 5, 2)->nullable();
            $table->decimal('tyres_score', 5, 2)->nullable();
            $table->decimal('frame_score', 5, 2)->nullable();
            $table->decimal('test_drive_score', 5, 2)->nullable();
            
            // Cost Estimates
            $table->decimal('immediate_repairs_cost', 10, 2)->default(0);
            $table->decimal('future_maintenance_cost', 10, 2)->default(0);
            $table->decimal('estimated_value', 10, 2)->nullable();
            
            // Summary and Notes
            $table->text('summary')->nullable();
            $table->text('major_issues')->nullable();
            $table->text('minor_issues')->nullable();
            $table->text('recommendations')->nullable();
            $table->text('inspector_notes')->nullable();
            
            // Test Drive Information
            $table->boolean('test_drive_performed')->default(false);
            $table->integer('test_drive_distance')->nullable(); // in km
            $table->text('test_drive_notes')->nullable();
            
            // Status and Timing
            $table->enum('status', ['in_progress', 'completed', 'reviewed', 'delivered'])->default('in_progress');
            $table->timestamp('started_at')->nullable();
            $table->timestamp('completed_at')->nullable();
            $table->timestamp('reviewed_at')->nullable();
            $table->timestamp('delivered_at')->nullable();
            
            $table->timestamps();
            
            $table->index(['status', 'created_at']);
            $table->index(['inspector_id', 'status']);
            $table->index(['overall_condition', 'recommendation']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('inspections');
    }
};