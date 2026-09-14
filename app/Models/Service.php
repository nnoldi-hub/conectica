<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

#[Fillable(['title', 'slug', 'description', 'sort_order', 'is_published'])]
class Service extends Model
{
    protected function scopePublished(Builder $query): void
    {
        $query->where('is_published', true);
    }
}
