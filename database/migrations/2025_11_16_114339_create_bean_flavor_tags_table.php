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
        Schema::create('bean_flavor_tags', function (Blueprint $table) {
            $table->id();
            $table->foreignId('bean_id')->constrained()->onDelete('cascade');
            $table->foreignId('flavor_tag_id')->constrained()->onDelete('cascade');
            $table->timestamps();

            // Unique constraint to prevent duplicate tags on the same bean
            $table->unique(['bean_id', 'flavor_tag_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bean_flavor_tags');
    }
};
