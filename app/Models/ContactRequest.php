<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;

#[Fillable(['name', 'email', 'phone', 'service', 'budget', 'message', 'status', 'contacted_at'])]
class ContactRequest extends Model
{
    public const STATUSES = [
        'new' => 'Nou',
        'reviewing' => 'In analiza',
        'contacted' => 'Contactat',
        'converted' => 'Convertit',
        'closed' => 'Inchis',
    ];

    protected static function booted(): void
    {
        static::saving(function (ContactRequest $contactRequest): void {
            if ($contactRequest->status === 'contacted' && ! $contactRequest->contacted_at) {
                $contactRequest->contacted_at = now();
            }
        });
    }

    protected function casts(): array
    {
        return [
            'contacted_at' => 'datetime',
        ];
    }
}
