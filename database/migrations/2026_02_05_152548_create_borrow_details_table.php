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
        Schema::create('borrow_details', function (Blueprint $table) {
            $table->id();

            $table->foreignId('borrow_id')
                ->constrained('borrows')
                ->cascadeOnDelete();

            $table->foreignId('book_item_id')
                ->constrained('book_items')
                ->cascadeOnDelete();

            $table->date('returned_at')->nullable();

            $table->enum('return_condition', ['good', 'damaged', 'lost'])
                ->nullable();

            $table->timestamps();

            $table->unique(['borrow_id', 'book_item_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('borrow_details');
    }
};
