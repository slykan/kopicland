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
        Schema::create('pricing_tiers', function (Blueprint $table) {
            $table->id();
            $table->foreignId('pricing_rule_id')->nullable()->constrained()->cascadeOnDelete();
            $table->unsignedTinyInteger('guests');
            $table->decimal('price_per_night', 8, 2);
            $table->timestamps();

            $table->unique(['pricing_rule_id', 'guests']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pricing_tiers');
    }
};
