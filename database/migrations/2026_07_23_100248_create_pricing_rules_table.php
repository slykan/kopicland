<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('pricing_rules', function (Blueprint $table) {
            $table->id();
            $table->foreignId('house_id')->constrained()->cascadeOnDelete();
            $table->enum('type', ['season', 'date'])->default('season');
            $table->json('label')->nullable();
            $table->date('date_from');
            $table->date('date_to');
            $table->decimal('price_per_night', 8, 2);
            $table->timestamps();

            $table->index(['house_id', 'date_from', 'date_to']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pricing_rules');
    }
};
