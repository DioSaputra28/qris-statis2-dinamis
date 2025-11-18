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
        Schema::create('transaction', function (Blueprint $table) {
            $table->uuid('transaction_id')->primary();
            $table->string('url');
            $table->integer('amount');
            $table->uuid('qris_id');
            $table->foreign('qris_id')->references('qris_id')->on('qris')->onDelete('cascade');
            $table->integer('total_click');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transaction');
    }
};
