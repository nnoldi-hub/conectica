<?php

namespace App\Models;

use App\Models\Concerns\HasOptimizedImage;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

#[Fillable(['title', 'slug', 'summary', 'image_path', 'image_original_path', 'image_variants', 'technologies', 'demo_url', 'github_url', 'sort_order', 'is_featured', 'is_published'])]
class Project extends Model
{
    use HasOptimizedImage;

    protected function casts(): array
    {
        return [
            'technologies' => 'array',
            'is_featured' => 'boolean',
            'is_published' => 'boolean',
            'image_variants' => 'array',
        ];
    }

    protected function scopePublished(Builder $query): void
    {
        $query->where('is_published', true);
    }
}
