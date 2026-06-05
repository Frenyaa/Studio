<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

class Setting extends Model
{
    protected $fillable = ['key', 'value'];

    protected static function booted(): void
    {
        static::saved(fn () => Cache::forget('settings_all'));
        static::deleted(fn () => Cache::forget('settings_all'));
    }

    /** Toàn bộ cài đặt dạng [key => value], có cache. */
    public static function allCached(): array
    {
        return Cache::rememberForever('settings_all', fn () => static::pluck('value', 'key')->toArray());
    }

    public static function getValue(string $key, $default = null)
    {
        $val = static::allCached()[$key] ?? null;

        return ($val === null || $val === '') ? $default : $val;
    }

    public static function setValue(string $key, $value): void
    {
        static::updateOrCreate(['key' => $key], ['value' => $value]);
    }
}
