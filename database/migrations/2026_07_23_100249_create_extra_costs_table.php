<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('extra_costs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('house_id')->nullable()->constrained()->cascadeOnDelete();
            $table->json('name');
            $table->decimal('amount', 8, 2);
            $table->enum('unit', ['one_time', 'per_night', 'per_person', 'per_person_per_night'])->default('one_time');
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('extra_costs');
    }
};
