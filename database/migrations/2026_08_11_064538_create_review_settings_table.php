<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('review_settings', function (Blueprint $table) {
            $table->id();
            $table->decimal('overall_rating', 2, 1)->default(5.0);
            $table->unsignedInteger('review_count')->nullable();
            $table->string('google_reviews_url')->nullable();
            $table->timestamps();
        });

        DB::table('review_settings')->insert([
            'overall_rating' => 4.9,
            'google_reviews_url' => 'https://www.google.hr/maps/place/Kopi%C4%87land/@45.3274029,18.8829071,17z/data=!4m9!3m8!1s0x475c8dc46c0f72a5:0xf8f77d8f20f6b993!5m2!4m1!1i2!8m2!3d45.3274029!4d18.885482!16s%2Fg%2F11q25t4h_m',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }

    public function down(): void
    {
        Schema::dropIfExists('review_settings');
    }
};
