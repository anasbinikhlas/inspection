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
        Schema::create('appointments', function (Blueprint $table) {
            $table->id();
            $table->string('appointment_number')->unique(); // APPT-2025-001
            $table->foreignId('customer_id')->constrained()->onDelete('cascade');
            $table->foreignId('location_id')->constrained()->onDelete('cascade');
            $table->foreignId('inspector_id')->nullable()->constrained()->onDelete('set null');
            
            // Vehicle Information
            $table->string('vehicle_make');
            $table->string('vehicle_model');
            $table->integer('vehicle_year');
            $table->string('vehicle_type'); // sedan, suv, truck, etc.
            $table->string('vin')->nullable();
            $table->string('license_plate')->nullable();
            $table->integer('mileage')->nullable();
            $table->string('color')->nullable();
            
            // Appointment Details
            $table->enum('package_type', ['basic', 'complete', 'premium'])->default('complete');
            $table->decimal('price', 8, 2);
            $table->date('appointment_date');
            $table->time('appointment_time');
            $table->integer('estimated_duration')->default(120); // minutes
            
            // Status and Notes
            $table->enum('status', [
                'pending', 'confirmed', 'in_progress', 'completed', 
                'cancelled', 'rescheduled', 'no_show'
            ])->default('pending');
            
            $table->text('customer_notes')->nullable();
            $table->text('internal_notes')->nullable();
            $table->text('cancellation_reason')->nullable();
            
            // Timestamps
            $table->timestamp('confirmed_at')->nullable();
            $table->timestamp('started_at')->nullable();
            $table->timestamp('completed_at')->nullable();
            $table->timestamp('cancelled_at')->nullable();
            $table->timestamps();
            
            $table->index(['status', 'appointment_date']);
            $table->index(['customer_id', 'status']);
            $table->index(['inspector_id', 'appointment_date']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('appointments');
    }
};