<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('houses', function (Blueprint $table) {
            $table->id();
            $table->string('slug')->unique();
            $table->json('name');
            $table->json('short_description')->nullable();
            $table->json('description')->nullable();
            $table->json('house_rules')->nullable();
            $table->json('seo_title')->nullable();
            $table->json('seo_description')->nullable();

            $table->unsignedTinyInteger('capacity_adults')->default(2);
            $table->unsignedTinyInteger('capacity_children')->default(0);
            $table->unsignedTinyInteger('bedrooms')->default(1);
            $table->unsignedTinyInteger('beds')->default(1);
            $table->unsignedTinyInteger('bathrooms')->default(1);
            $table->unsignedInteger('size_m2')->nullable();

            $table->decimal('lat', 10, 7)->nullable();
            $table->decimal('lng', 10, 7)->nullable();

            $table->time('check_in_time')->nullable();
            $table->time('check_out_time')->nullable();
            $table->boolean('pets_allowed')->default(false);
            $table->boolean('parking_available')->default(false);

            $table->decimal('base_price_per_night', 8, 2)->default(0);

            $table->enum('status', ['draft', 'published', 'unpublished', 'archived'])->default('draft');
            $table->boolean('is_featured')->default(false);
            $table->unsignedInteger('sort_order')->default(0);

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('houses');
    }
};
