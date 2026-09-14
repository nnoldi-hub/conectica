<?php

namespace App\Models;

use App\Services\ImageOptimizer;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

#[Fillable(['title', 'file_path', 'disk', 'alt_text', 'mime_type', 'size', 'original_path', 'variants', 'width', 'height'])]
class Media extends Model
{
    protected static function booted(): void
    {
        static::saving(function (Media $media): void {
            if (! $media->file_path || ! Storage::disk($media->disk)->exists($media->file_path)) {
                return;
            }

            if (! $media->original_path) {
                $optimized = app(ImageOptimizer::class)->optimize(Storage::disk($media->disk), $media->file_path);
                $media->file_path = $optimized['file_path'];
                $media->original_path = $optimized['original_path'];
                $media->variants = $optimized['variants'];
                $media->mime_type = $optimized['mime_type'];
                $media->size = $optimized['size'];
                $media->width = $optimized['width'];
                $media->height = $optimized['height'];
            } else {
                $media->mime_type = Storage::disk($media->disk)->mimeType($media->file_path) ?: 'application/octet-stream';
                $media->size = Storage::disk($media->disk)->size($media->file_path);
            }

            $media->title = $media->title ?: pathinfo($media->file_path, PATHINFO_FILENAME);
        });

        static::deleting(function (Media $media): void {
            $disk = Storage::disk($media->disk);
            $disk->delete(array_filter([
                $media->file_path,
                $media->original_path,
                ...array_values($media->variants ?? []),
            ]));
        });
    }

    protected function casts(): array
    {
        return [
            'size' => 'integer',
            'variants' => 'array',
            'width' => 'integer',
            'height' => 'integer',
        ];
    }

    public function getUrlAttribute(): string
    {
        return Storage::disk($this->disk)->url($this->file_path);
    }
}
