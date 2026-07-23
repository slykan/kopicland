<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('discounts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('house_id')->nullable()->constrained()->cascadeOnDelete();
            $table->enum('type', ['long_stay', 'early_bird', 'last_minute', 'promo_code', 'manual']);
            $table->json('label')->nullable();
            $table->string('code')->nullable()->unique();
            $table->decimal('value', 8, 2);
            $table->enum('value_type', ['percent', 'fixed'])->default('percent');
            $table->unsignedInteger('min_nights')->nullable();
            $table->unsignedInteger('threshold_days')->nullable();
            $table->date('active_from')->nullable();
            $table->date('active_until')->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('discounts');
    }
};
