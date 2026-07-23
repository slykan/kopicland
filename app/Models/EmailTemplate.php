<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;

class EmailTemplate extends Model
{
    use HasTranslations;

    public array $translatable = ['subject', 'body'];

    protected $fillable = ['key', 'recipient', 'subject', 'body', 'is_active'];

    protected function casts(): array
    {
        return [
            'is_active' => 'boolean',
        ];
    }
}
