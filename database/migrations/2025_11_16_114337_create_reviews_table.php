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
        Schema::create('reviews', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('bean_id')->constrained()->onDelete('cascade');
            $table->decimal('rating_overall', 3, 1);
            $table->decimal('rating_aroma', 3, 1)->nullable();
            $table->decimal('rating_acidity', 3, 1)->nullable();
            $table->decimal('rating_body', 3, 1)->nullable();
            $table->decimal('rating_flavor', 3, 1)->nullable();
            $table->decimal('rating_aftertaste', 3, 1)->nullable();
            $table->string('brewing_method')->nullable();
            $table->text('review_text')->nullable();
            $table->boolean('would_buy_again')->default(true);
            $table->integer('helpful_count')->default(0);
            $table->timestamps();

            // Indexes
            $table->index(['bean_id', 'rating_overall']);
            $table->index('user_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reviews');
    }
};
