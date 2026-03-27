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
        Schema::create('entries', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('cash_draw_id')->nullable()->constrained()->onDelete('cascade');
            $table->foreignId('product_draw_id')->nullable()->constrained()->onDelete('cascade');
            $table->enum('type', ['cash', 'product']);
            $table->string('entry_number')->nullable();
            $table->dateTime('entry_date');
            $table->decimal('amount_paid', 15, 2)->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('entries');
    }
};
