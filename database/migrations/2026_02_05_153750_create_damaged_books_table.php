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
        Schema::create('damaged_books', function (Blueprint $table) {
            $table->id();

            $table->foreignId('borrow_detail_id')
                ->constrained('borrow_details')
                ->cascadeOnDelete();

            $table->foreignId('book_item_id')
                ->constrained('book_items')
                ->cascadeOnDelete();

            $table->enum('damage_level', ['light', 'medium', 'heavy']);
            $table->text('description')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('damaged_books');
    }
};
