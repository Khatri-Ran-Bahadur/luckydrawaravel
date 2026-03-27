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
        Schema::create('winners', function (Blueprint $table) {
            $table->id();
            $table->foreignId('cash_draw_id')->nullable()->constrained()->onDelete('cascade');
            $table->foreignId('product_draw_id')->nullable()->constrained()->onDelete('cascade');
            $table->enum('draw_type', ['cash', 'product'])->default('cash');
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->integer('position')->nullable();
            $table->decimal('prize_amount', 15, 2)->default(0);
            $table->boolean('is_claimed')->default(false);
            $table->text('claim_details')->nullable();
            $table->boolean('claimed_approved')->default(false);
            $table->integer('participant_count')->default(0);
            $table->dateTime('approved_at')->nullable();
            $table->string('reject_comment')->nullable();
            $table->string('status')->default('waiting_claim');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('winners');
    }
};
