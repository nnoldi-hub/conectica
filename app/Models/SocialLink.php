<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

#[Fillable(['platform', 'url', 'sort_order', 'is_published'])]
class SocialLink extends Model
{
    /**
     * Platforme disponibile si etichetele lor afisate in admin.
     *
     * @return array<string, string>
     */
    public static function platforms(): array
    {
        return [
            'facebook' => 'Facebook',
            'instagram' => 'Instagram',
            'linkedin' => 'LinkedIn',
            'tiktok' => 'TikTok',
            'youtube' => 'YouTube',
            'x' => 'X (Twitter)',
            'github' => 'GitHub',
            'whatsapp' => 'WhatsApp',
        ];
    }

    protected function casts(): array
    {
        return [
            'is_published' => 'boolean',
        ];
    }

    protected function scopePublished(Builder $query): void
    {
        $query->where('is_published', true)->orderBy('sort_order');
    }
}
