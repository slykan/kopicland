<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class PopupSetting extends Model
{
    protected $fillable = [
        'is_active', 'image_path', 'link_url', 'alt_text',
    ];

    protected function casts(): array
    {
        return [
            'is_active' => 'boolean',
        ];
    }

    public static function current(): self
    {
        return static::query()->firstOrCreate(['id' => 1], ['is_active' => false]);
    }

    /** The popup to show on the public site, or null when it is offline or has no image. */
    public static function visible(): ?self
    {
        $popup = static::query()->find(1);

        return $popup && $popup->is_active && $popup->image_path ? $popup : null;
    }

    public function imageUrl(): string
    {
        return Storage::disk('public')->url($this->image_path);
    }
}
