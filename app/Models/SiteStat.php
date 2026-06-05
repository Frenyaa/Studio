<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SiteStat extends Model
{
    use HasFactory;

    protected $fillable = [
        'label',
        'value',
        'prefix',
        'suffix',
        'sort_order',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'sort_order' => 'integer',
    ];

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /** Phần số nguyên để Counter chạy số (loại bỏ ký tự không phải số). */
    public function getNumericValueAttribute(): int
    {
        return (int) preg_replace('/\D/', '', $this->value);
    }
}
