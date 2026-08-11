<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ReviewSetting extends Model
{
    protected $fillable = [
        'overall_rating', 'review_count', 'google_reviews_url',
    ];

    protected function casts(): array
    {
        return [
            'overall_rating' => 'decimal:1',
        ];
    }

    public static function current(): self
    {
        return static::query()->firstOrCreate(['id' => 1], ['overall_rating' => 5.0]);
    }
}
