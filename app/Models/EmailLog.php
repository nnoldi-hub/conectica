<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

#[Fillable(['contact_request_id', 'mailable', 'to_email', 'subject', 'status', 'tracking_token', 'sent_at', 'opened_at'])]
class EmailLog extends Model
{
    public const STATUSES = [
        'queued' => 'In coada',
        'sent' => 'Trimis',
        'opened' => 'Deschis',
        'failed' => 'Esuat',
    ];

    protected function casts(): array
    {
        return [
            'sent_at' => 'datetime',
            'opened_at' => 'datetime',
        ];
    }

    public function contactRequest(): BelongsTo
    {
        return $this->belongsTo(ContactRequest::class);
    }
}
