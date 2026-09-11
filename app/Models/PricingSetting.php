<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PricingSetting extends Model
{
    protected $fillable = [
        'default_price_per_night',
    ];

    protected function casts(): array
    {
        return [
            'default_price_per_night' => 'decimal:2',
        ];
    }

    public static function current(): self
    {
        return static::query()->firstOrCreate(['id' => 1], ['default_price_per_night' => 0]);
    }
}
