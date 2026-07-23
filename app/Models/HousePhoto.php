<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Spatie\Translatable\HasTranslations;

class HousePhoto extends Model
{
    use HasTranslations;

    public array $translatable = ['alt_text'];

    protected $fillable = ['house_id', 'path', 'alt_text', 'is_cover', 'sort_order'];

    protected function casts(): array
    {
        return [
            'is_cover' => 'boolean',
        ];
    }

    public function house(): BelongsTo
    {
        return $this->belongsTo(House::class);
    }
}
