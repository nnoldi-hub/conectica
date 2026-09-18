<?php

namespace App\Models;

use App\Models\Concerns\HasOptimizedImage;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Casts\Attribute;
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

    /**
     * Continutul articolului, pregatit sigur pentru afisare HTML.
     *
     * Articolele vechi au fost salvate ca text simplu, cu paragrafe separate
     * prin linii goale. Cele noi vin din editorul rich text din admin si
     * contin deja markup HTML (ex. <p>, <strong>). Acest accesor trateaza
     * ambele cazuri si curata orice markup potential periculos.
     */
    protected function bodyHtml(): Attribute
    {
        return Attribute::make(
            get: function (): string {
                $body = trim((string) $this->body);

                if ($body === '') {
                    return '';
                }

                if (! str_contains($body, '<')) {
                    $blocks = preg_split('/\n{2,}/', $body) ?: [];

                    return collect($blocks)
                        ->map(function (string $block): string {
                            $block = trim($block);

                            if (str_starts_with($block, '### ')) {
                                return '<h3>'.e(trim(substr($block, 4))).'</h3>';
                            }

                            if (str_starts_with($block, '## ')) {
                                return '<h2>'.e(trim(substr($block, 3))).'</h2>';
                            }

                            return '<p>'.nl2br(e($block)).'</p>';
                        })
                        ->implode('');
                }

                return $this->sanitizeBodyHtml($body);
            },
        );
    }

    protected function sanitizeBodyHtml(string $html): string
    {
        $allowedTags = '<p><br><strong><b><em><i><u><s><ul><ol><li><a><h1><h2><h3><h4><blockquote><img><span><code><pre>';

        $clean = strip_tags($html, $allowedTags);
        $clean = preg_replace('/\s+on[a-z]+\s*=\s*(["\']).*?\1/i', '', $clean) ?? $clean;
        $clean = preg_replace('/(href|src)\s*=\s*(["\'])\s*javascript:[^"\']*\2/i', '$1="#"', $clean) ?? $clean;

        return $clean;
    }
}
