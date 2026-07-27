<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Spatie\Translatable\HasTranslations;

class PricingRule extends Model
{
    use HasTranslations;

    public array $translatable = ['label'];

    protected $fillable = ['house_id', 'type', 'label', 'date_from', 'date_to', 'price_per_night'];

    protected function casts(): array
    {
        return [
            'date_from' => 'date',
            'date_to' => 'date',
            'price_per_night' => 'decimal:2',
        ];
    }

    public function house(): BelongsTo
    {
        return $this->belongsTo(House::class);
    }

    public function tiers(): HasMany
    {
        return $this->hasMany(PricingTier::class);
    }
}
