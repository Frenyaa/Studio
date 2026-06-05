<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;

class ProjectCategory extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
        'description',
        'sort_order',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'sort_order' => 'integer',
    ];

    protected static function booted(): void
    {
        static::saving(function (ProjectCategory $category) {
            if (blank($category->slug)) {
                $category->slug = Str::slug($category->name);
            }
        });
    }

    public function projects(): HasMany
    {
        return $this->hasMany(Project::class);
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeOrdered($query)
    {
        return $query->orderBy('sort_order');
    }

    /** Ảnh đại diện danh mục: lấy ảnh dự án đầu tiên thuộc danh mục. */
    public function getCoverImageAttribute(): ?string
    {
        $project = $this->relationLoaded('projects')
            ? $this->projects->where('is_published', true)->sortBy('sort_order')->first()
            : $this->projects()->where('is_published', true)->orderBy('sort_order')->first();

        return optional($project)->grid_image;
    }
}
