<?php

namespace Database\Seeders;

use App\Models\PricingTier;
use Illuminate\Database\Seeder;

class PricingTierSeeder extends Seeder
{
    /**
     * Global base tiers (pricing_rule_id null): price per night by total
     * guest count. 1 guest shares the 2-guest rate (lowest defined tier).
     */
    public function run(): void
    {
        $tiers = [
            ['guests' => 2, 'price_per_night' => 90],
            ['guests' => 3, 'price_per_night' => 105],
            ['guests' => 4, 'price_per_night' => 120],
            ['guests' => 5, 'price_per_night' => 130],
            ['guests' => 6, 'price_per_night' => 140],
        ];

        foreach ($tiers as $tier) {
            PricingTier::updateOrCreate(
                ['pricing_rule_id' => null, 'guests' => $tier['guests']],
                ['price_per_night' => $tier['price_per_night']],
            );
        }
    }
}
