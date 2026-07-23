<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Spatie\Translatable\HasTranslations;

class House extends Model
{
    use HasTranslations;

    public array $translatable = [
        'name', 'short_description', 'description', 'house_rules', 'seo_title', 'seo_description',
    ];

    protected $fillable = [
        'slug', 'name', 'short_description', 'description', 'house_rules', 'seo_title', 'seo_description',
        'capacity_adults', 'capacity_children', 'bedrooms', 'beds', 'bathrooms', 'size_m2',
        'lat', 'lng', 'check_in_time', 'check_out_time', 'pets_allowed', 'parking_available',
        'base_price_per_night', 'status', 'is_featured', 'sort_order',
    ];

    protected function casts(): array
    {
        return [
            'pets_allowed' => 'boolean',
            'parking_available' => 'boolean',
            'is_featured' => 'boolean',
            'base_price_per_night' => 'decimal:2',
            'lat' => 'decimal:7',
            'lng' => 'decimal:7',
        ];
    }

    public function photos(): HasMany
    {
        return $this->hasMany(HousePhoto::class)->orderBy('sort_order');
    }

    public function amenities(): BelongsToMany
    {
        return $this->belongsToMany(Amenity::class, 'house_amenity');
    }

    public function pricingRules(): HasMany
    {
        return $this->hasMany(PricingRule::class);
    }

    public function extraCosts(): HasMany
    {
        return $this->hasMany(ExtraCost::class);
    }

    public function discounts(): HasMany
    {
        return $this->hasMany(Discount::class);
    }

    public function stayRules(): HasMany
    {
        return $this->hasMany(StayRule::class);
    }

    public function reservations(): HasMany
    {
        return $this->hasMany(Reservation::class);
    }
}
