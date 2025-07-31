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
        Schema::create('inspectors', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('employee_id')->unique();
            $table->string('first_name');
            $table->string('last_name');
            $table->string('email')->unique();
            $table->string('phone');
            $table->string('license_number')->nullable();
            $table->date('license_expiry')->nullable();
            $table->json('certifications')->nullable(); // Store array of certifications
            $table->json('specializations')->nullable(); // Vehicle types they can inspect
            $table->enum('status', ['active', 'inactive', 'on_leave'])->default('active');
            $table->decimal('hourly_rate', 8, 2)->nullable();
            $table->date('hire_date');
            $table->text('bio')->nullable();
            $table->string('profile_photo')->nullable();
            $table->timestamps();
            
            $table->index(['status', 'employee_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('inspectors');
    }
};