<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Post extends Model
{
    use HasFactory;

    /** Chủ đề blog set sẵn (slug => nhãn) — admin chọn, không gõ tay. */
    public const CATEGORIES = [
        'cam-hung-sang-tao' => 'Cảm hứng sáng tạo',
        'xu-huong' => 'Xu hướng',
        'meo-thiet-ke' => 'Mẹo thiết kế',
        'vat-lieu' => 'Vật liệu',
        'phong-cach' => 'Phong cách',
        'kinh-nghiem' => 'Kinh nghiệm chọn mua',
    ];

    protected $fillable = [
        'title',
        'slug',
        'cover_image',
        'excerpt',
        'content',
        'category',
        'is_published',
        'published_at',
        'sort_order',
        'meta_title',
        'meta_description',
    ];

    protected $casts = [
        'is_published' => 'boolean',
        'published_at' => 'datetime',
        'sort_order' => 'integer',
    ];

    protected static function booted(): void
    {
        static::saving(function (Post $post) {
            if (blank($post->slug)) {
                $post->slug = Str::slug($post->title);
            }
            if ($post->is_published && blank($post->published_at)) {
                $post->published_at = now();
            }
        });
    }

    public function getRouteKeyName(): string
    {
        return 'slug';
    }

    /** Nhãn hiển thị của chủ đề. */
    public function getCategoryLabelAttribute(): ?string
    {
        return self::CATEGORIES[$this->category] ?? $this->category;
    }

    public function scopePublished($query)
    {
        return $query->where('is_published', true)
            ->where(fn ($q) => $q->whereNull('published_at')->orWhere('published_at', '<=', now()));
    }

    public function scopeLatestPosts($query)
    {
        return $query->orderByDesc('published_at')->orderByDesc('created_at');
    }
}
