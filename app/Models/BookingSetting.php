<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BookingSetting extends Model
{
    protected $fillable = ['online_booking'];

    protected function casts(): array
    {
        return [
            'online_booking' => 'boolean',
        ];
    }

    public static function current(): self
    {
        return static::query()->firstOrCreate(['id' => 1], ['online_booking' => true]);
    }

    /** False when the admin switched online booking off: house pages then show an inquiry form instead. */
    public static function onlineBookingEnabled(): bool
    {
        return (bool) (static::query()->find(1)?->online_booking ?? true);
    }
}
