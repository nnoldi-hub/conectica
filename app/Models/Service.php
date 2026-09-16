<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

#[Fillable(['title', 'slug', 'icon', 'description', 'highlights', 'price_note', 'sort_order', 'is_published'])]
class Service extends Model
{
    protected function casts(): array
    {
        return [
            'highlights' => 'array',
            'is_published' => 'boolean',
        ];
    }

    protected function scopePublished(Builder $query): void
    {
        $query->where('is_published', true);
    }
}
