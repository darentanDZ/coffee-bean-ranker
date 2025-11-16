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
        Schema::create('beans', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('roaster');
            $table->string('origin_country')->nullable();
            $table->string('origin_region')->nullable();
            $table->string('farm')->nullable();
            $table->integer('altitude')->nullable();
            $table->enum('roast_level', ['light', 'medium', 'medium-dark', 'dark'])->nullable();
            $table->enum('processing_method', ['washed', 'natural', 'honey', 'experimental'])->nullable();
            $table->string('varietal')->nullable();
            $table->date('harvest_date')->nullable();
            $table->decimal('price', 8, 2)->nullable();
            $table->integer('bag_size_grams')->nullable();
            $table->string('image_url')->nullable();
            $table->text('description')->nullable();
            $table->foreignId('created_by_user_id')->constrained('users')->onDelete('cascade');
            $table->boolean('verified')->default(false);
            $table->timestamps();

            // Indexes for search
            $table->index(['name', 'roaster']);
            $table->index('origin_country');
            $table->index('roast_level');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('beans');
    }
};
