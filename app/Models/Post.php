<?php

namespace App\Models;

use App\Models\Concerns\HasOptimizedImage;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

#[Fillable(['post_category_id', 'title', 'slug', 'excerpt', 'body', 'image_path', 'image_original_path', 'image_variants', 'tags', 'seo_title', 'seo_description', 'published_at', 'is_published'])]
class Post extends Model
{
    use HasOptimizedImage;

    protected function casts(): array
    {
        return [
            'tags' => 'array',
            'published_at' => 'datetime',
            'is_published' => 'boolean',
            'image_variants' => 'array',
        ];
    }

    protected function scopePublished(Builder $query): void
    {
        $query->where('is_published', true)
            ->whereNotNull('published_at')
            ->where('published_at', '<=', now());
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(PostCategory::class, 'post_category_id');
    }
}
