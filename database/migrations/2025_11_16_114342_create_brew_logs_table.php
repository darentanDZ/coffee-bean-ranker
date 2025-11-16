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
        Schema::create('brew_logs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('bean_id')->constrained()->onDelete('cascade');
            $table->string('brewing_method');
            $table->string('grind_size')->nullable();
            $table->integer('water_temp')->nullable();
            $table->integer('brew_time')->nullable();
            $table->string('ratio')->nullable();
            $table->text('notes')->nullable();
            $table->decimal('rating', 3, 1)->nullable();
            $table->string('image_url')->nullable();
            $table->timestamps();

            // Index for user's brew logs
            $table->index('user_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('brew_logs');
    }
};
