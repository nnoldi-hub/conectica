<?php

namespace App\Listeners;

use App\Models\EmailLog;
use Illuminate\Mail\Events\MessageSent;

class MarkEmailLogAsSent
{
    public function handle(MessageSent $event): void
    {
        $token = $event->message->getHeaders()->get('X-Tracking-Token')?->getBodyAsString();

        if (! $token) {
            return;
        }

        EmailLog::query()
            ->where('tracking_token', $token)
            ->where('status', 'queued')
            ->update([
                'status' => 'sent',
                'sent_at' => now(),
            ]);
    }
}
