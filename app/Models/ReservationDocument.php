<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ReservationDocument extends Model
{
    protected $fillable = ['reservation_id', 'path', 'label'];

    public function reservation(): BelongsTo
    {
        return $this->belongsTo(Reservation::class);
    }
}
