<?php

namespace App\Models\Concerns;

use App\Services\ImageOptimizer;
use Illuminate\Support\Facades\Storage;

trait HasOptimizedImage
{
    protected static function bootHasOptimizedImage(): void
    {
        static::saving(function ($model): void {
            if (! $model->image_path || $model->image_original_path || ! Storage::disk('public')->exists($model->image_path)) {
                return;
            }

            $optimized = app(ImageOptimizer::class)->optimize(Storage::disk('public'), $model->image_path);
            $model->image_path = $optimized['file_path'];
            $model->image_original_path = $optimized['original_path'];
            $model->image_variants = $optimized['variants'];
        });

        static::deleting(function ($model): void {
            Storage::disk('public')->delete(array_filter([
                $model->image_path,
                $model->image_original_path,
                ...array_values($model->image_variants ?? []),
            ]));
        });
    }
}
