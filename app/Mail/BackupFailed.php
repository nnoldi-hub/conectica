<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class BackupFailed extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(public string $errorMessage) {}

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'ATENTIE: Backup Conectica IT esuat',
        );
    }

    public function content(): Content
    {
        return new Content(
            markdown: 'mail.backup-failed',
        );
    }
}
