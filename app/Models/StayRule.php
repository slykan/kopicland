<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class StayRule extends Model
{
    protected $fillable = [
        'house_id', 'date_from', 'date_to', 'min_nights', 'max_nights',
        'allowed_arrival_days', 'allowed_departure_days',
    ];

    protected function casts(): array
    {
        return [
            'date_from' => 'date',
            'date_to' => 'date',
            'allowed_arrival_days' => 'array',
            'allowed_departure_days' => 'array',
        ];
    }

    public function house(): BelongsTo
    {
        return $this->belongsTo(House::class);
    }
}
