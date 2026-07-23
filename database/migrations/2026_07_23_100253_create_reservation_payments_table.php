<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('reservation_payments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('reservation_id')->constrained()->cascadeOnDelete();
            $table->enum('type', ['deposit', 'balance', 'refund'])->default('deposit');
            $table->decimal('amount', 8, 2);
            $table->enum('status', ['unpaid', 'partially_paid', 'paid', 'refunded'])->default('unpaid');
            $table->string('method')->nullable();
            $table->date('paid_at')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('reservation_payments');
    }
};
