<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Guest extends Model
{
    protected $fillable = [
        'first_name', 'last_name', 'email', 'phone', 'country', 'address',
        'preferred_locale', 'marketing_consent', 'rules_accepted_at', 'privacy_accepted_at', 'notes',
    ];

    protected function casts(): array
    {
        return [
            'marketing_consent' => 'boolean',
            'rules_accepted_at' => 'datetime',
            'privacy_accepted_at' => 'datetime',
        ];
    }

    public function reservations(): HasMany
    {
        return $this->hasMany(Reservation::class);
    }
}
