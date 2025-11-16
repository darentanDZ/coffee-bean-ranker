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
        Schema::create('user_beans', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('bean_id')->constrained()->onDelete('cascade');
            $table->date('purchase_date')->nullable();
            $table->string('purchase_location')->nullable();
            $table->date('roast_date')->nullable();
            $table->decimal('price_paid', 8, 2)->nullable();
            $table->enum('status', ['current', 'finished', 'stale', 'wishlist'])->default('current');
            $table->text('notes')->nullable();
            $table->timestamps();

            // Index for user's bean collection
            $table->index(['user_id', 'status']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_beans');
    }
};
