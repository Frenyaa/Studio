<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;

class Project extends Model
{
    use HasFactory;

    protected $fillable = [
        'project_category_id',
        'title',
        'slug',
        'sku',
        'dimensions',
        'material',
        'colors',
        'location',
        'area',
        'year_completed',
        'client_name',
        'style',
        'cover_image',
        'thumbnail',
        'summary',
        'description',
        'is_featured',
        'is_published',
        'sort_order',
        'meta_title',
        'meta_description',
    ];

    protected $casts = [
        'is_featured' => 'boolean',
        'is_published' => 'boolean',
        'sort_order' => 'integer',
        'year_completed' => 'integer',
    ];

    protected static function booted(): void
    {
        static::saving(function (Project $project) {
            if (blank($project->slug)) {
                $project->slug = Str::slug($project->title);
            }
        });
    }

    public function getRouteKeyName(): string
    {
        return 'slug';
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(ProjectCategory::class, 'project_category_id');
    }

    public function images(): HasMany
    {
        return $this->hasMany(ProjectImage::class)->orderBy('sort_order');
    }

    public function scopePublished($query)
    {
        return $query->where('is_published', true);
    }

    public function scopeFeatured($query)
    {
        return $query->where('is_featured', true);
    }

    public function scopeOrdered($query)
    {
        return $query->orderBy('sort_order')->orderByDesc('created_at');
    }

    /** Ảnh hiển thị trên lưới: ưu tiên thumbnail tối ưu, fallback cover. */
    public function getGridImageAttribute(): ?string
    {
        return $this->thumbnail ?: $this->cover_image;
    }
}
