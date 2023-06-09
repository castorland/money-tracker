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
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('amount')->index();
            $table->unsignedBigInteger('category_id')->index();
            $table->string('note')->nullable();
            $table->timestamp('transaction_date')->index();
            $table->boolean('is_recurring')->index();
            $table->unsignedSmallInteger('recurring_frequency')->nullable();
            $table->string('recurring_period', 10)->nullable();
            $table->date('recurring_on')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transactions');
    }
};
