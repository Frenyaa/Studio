<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HeroSlide extends Model
{
    use HasFactory;

    protected $fillable = [
        'video_file',
        'video_url',
        'poster_image',
        'poster_url',
        'slogan',
        'sub_slogan',
        'cta_label',
        'cta_anchor',
        'show_logo_overlay',
        'is_active',
        'sort_order',
    ];

    protected $casts = [
        'show_logo_overlay' => 'boolean',
        'is_active' => 'boolean',
        'sort_order' => 'integer',
    ];

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /** Nguồn video: ưu tiên file upload, fallback link ngoài. */
    public function getVideoSourceAttribute(): ?string
    {
        if ($this->video_file) {
            return asset('storage/' . $this->video_file);
        }

        return $this->video_url;
    }

    /** Nguồn ảnh poster: ưu tiên link ngoài, fallback file upload. */
    public function getPosterSourceAttribute(): ?string
    {
        if ($this->poster_url) {
            return $this->poster_url;
        }

        return $this->poster_image ? asset('storage/' . $this->poster_image) : null;
    }
}

