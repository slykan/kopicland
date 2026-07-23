<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Spatie\Translatable\HasTranslations;

class Discount extends Model
{
    use HasTranslations;

    public array $translatable = ['label'];

    protected $fillable = [
        'house_id', 'type', 'label', 'code', 'value', 'value_type',
        'min_nights', 'threshold_days', 'active_from', 'active_until', 'is_active',
    ];

    protected function casts(): array
    {
        return [
            'value' => 'decimal:2',
            'active_from' => 'date',
            'active_until' => 'date',
            'is_active' => 'boolean',
        ];
    }

    public function house(): BelongsTo
    {
        return $this->belongsTo(House::class);
    }
}
