<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;

class ProductCategory extends Model
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
        static::saving(function (ProductCategory $category) {
            if (blank($category->slug)) {
                $category->slug = Str::slug($category->name);
            }
        });
    }

    public function products(): HasMany
    {
        return $this->hasMany(Product::class);
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeOrdered($query)
    {
        return $query->orderBy('sort_order');
    }

    /** Ảnh đại diện danh mục: lấy ảnh sản phẩm đầu tiên thuộc danh mục. */
    public function getCoverImageAttribute(): ?string
    {
        $product = $this->relationLoaded('products')
            ? $this->products->where('is_published', true)->sortBy('sort_order')->first()
            : $this->products()->where('is_published', true)->orderBy('sort_order')->first();

        return optional($product)->grid_image;
    }
}
