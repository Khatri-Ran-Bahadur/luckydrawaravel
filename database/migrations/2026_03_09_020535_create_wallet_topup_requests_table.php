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
        Schema::create('wallet_topup_requests', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->bigInteger('special_user_id')->default(0);
            $table->decimal('amount', 15, 2);
            $table->string('currency', 10)->default('USD');
            $table->string('payment_method')->nullable();
            $table->string('payment_proof')->nullable();
            $table->string('status')->default('pending');
            $table->string('admin_note')->nullable();
            $table->string('special_user_note')->nullable();
            $table->bigInteger('processed_by')->nullable();
            $table->dateTime('processed_at')->nullable();
            $table->dateTime('special_user_processed_at')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('wallet_topup_requests');
    }
};
