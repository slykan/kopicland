<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PricingTier extends Model
{
    protected $fillable = ['pricing_rule_id', 'guests', 'price_per_night'];

    protected function casts(): array
    {
        return [
            'guests' => 'integer',
            'price_per_night' => 'decimal:2',
        ];
    }

    public function pricingRule(): BelongsTo
    {
        return $this->belongsTo(PricingRule::class);
    }
}
