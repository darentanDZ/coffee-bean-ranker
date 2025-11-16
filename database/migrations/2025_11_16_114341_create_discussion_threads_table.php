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
        Schema::create('discussion_threads', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('category');
            $table->string('title');
            $table->text('content');
            $table->boolean('pinned')->default(false);
            $table->boolean('locked')->default(false);
            $table->integer('view_count')->default(0);
            $table->timestamps();

            // Indexes
            $table->index('category');
            $table->index(['pinned', 'created_at']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('discussion_threads');
    }
};
