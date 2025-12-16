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
        Schema::create('product_draws', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('product_name');
            $table->string('product_image')->nullable();
            $table->text('description')->nullable();
            $table->decimal('entry_fee', 15, 2);
            $table->decimal('product_price', 15, 2);
            $table->dateTime('draw_date');
            $table->boolean('is_manual_selection')->default(false);
            $table->enum('status', ['active', 'inactive', 'completed'])->default('active');
            $table->integer('total_winners')->default(0);
            $table->integer('participant_count')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('product_draws');
    }
};
