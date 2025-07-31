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
        Schema::create('inspection_photos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('inspection_id')->constrained()->onDelete('cascade');
            $table->foreignId('inspection_item_id')->nullable()->constrained()->onDelete('set null');
            
            // File Information
            $table->string('filename');
            $table->string('original_filename');
            $table->string('file_path');
            $table->string('file_url')->nullable(); // If using cloud storage
            $table->string('mime_type');
            $table->integer('file_size'); // in bytes
            $table->integer('width')->nullable();
            $table->integer('height')->nullable();
            
            // Photo Details
            $table->string('category'); // engine, brakes, exterior, damage, etc.
            $table->string('title')->nullable();
            $table->text('description')->nullable();
            $table->enum('photo_type', [
                'overview', 'detail', 'damage', 'measurement', 
                'before', 'after', 'reference'
            ])->default('detail');
            
            // Position and Context
            $table->string('vehicle_position')->nullable(); // front, rear, left_side, etc.
            $table->json('damage_coordinates')->nullable(); // For damage mapping
            $table->integer('sequence_order')->default(1); // Order within category
            
            // Metadata
            $table->json('exif_data')->nullable(); // Camera settings, GPS, etc.
            $table->timestamp('taken_at')->nullable();
            $table->boolean('is_primary')->default(false); // Main photo for category
            $table->boolean('include_in_report')->default(true);
            $table->boolean('customer_visible')->default(true);
            
            $table->timestamps();
            
            $table->index(['inspection_id', 'category']);
            $table->index(['photo_type', 'is_primary']);
            $table->index(['inspection_item_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('inspection_photos');
    }
};