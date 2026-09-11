<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('pricing_settings', function (Blueprint $table) {
            $table->id();
            $table->decimal('default_price_per_night', 8, 2)->default(0);
            $table->timestamps();
        });

        // Carry the previous global "2 guests" tier forward as the new flat
        // default so existing bookings don't suddenly price at 0 EUR/night;
        // the admin still needs to review it on the new Default Pricing page.
        $previousDefault = Schema::hasTable('pricing_tiers')
            ? DB::table('pricing_tiers')->whereNull('pricing_rule_id')->orderBy('guests')->value('price_per_night')
            : null;

        DB::table('pricing_settings')->insert([
            'id' => 1,
            'default_price_per_night' => $previousDefault ?? 0,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pricing_settings');
    }
};
