<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Reservation extends Model
{
    protected $fillable = [
        'house_id', 'guest_id', 'check_in', 'check_out', 'adults', 'children', 'pets',
        'status', 'source', 'locale', 'total_price', 'discount_amount',
        'guest_note', 'internal_note', 'hold_expires_at', 'confirmed_at', 'cancelled_at', 'created_by',
    ];

    protected function casts(): array
    {
        return [
            'check_in' => 'date',
            'check_out' => 'date',
            'total_price' => 'decimal:2',
            'discount_amount' => 'decimal:2',
            'hold_expires_at' => 'datetime',
            'confirmed_at' => 'datetime',
            'cancelled_at' => 'datetime',
        ];
    }

    public function house(): BelongsTo
    {
        return $this->belongsTo(House::class);
    }

    public function guest(): BelongsTo
    {
        return $this->belongsTo(Guest::class);
    }

    public function createdBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function payments(): HasMany
    {
        return $this->hasMany(ReservationPayment::class);
    }

    public function documents(): HasMany
    {
        return $this->hasMany(ReservationDocument::class);
    }

    public function logs(): HasMany
    {
        return $this->hasMany(ReservationLog::class);
    }
}
