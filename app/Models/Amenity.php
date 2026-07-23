<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Spatie\Translatable\HasTranslations;

class Amenity extends Model
{
    use HasTranslations;

    public array $translatable = ['name'];

    protected $fillable = ['name', 'icon', 'sort_order'];

    public function houses(): BelongsToMany
    {
        return $this->belongsToMany(House::class, 'house_amenity');
    }
}
