<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Attachment;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class BackupSucceeded extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(
        public string $dumpPath,
        public ?string $filesZipPath,
        public ?string $attachedDumpPath,
    ) {}

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Backup Conectica IT finalizat cu succes',
        );
    }

    public function content(): Content
    {
        return new Content(
            markdown: 'mail.backup-succeeded',
            with: [
                'dumpName' => basename($this->dumpPath),
                'filesZipName' => $this->filesZipPath ? basename($this->filesZipPath) : null,
                'dumpSize' => $this->formatBytes(filesize($this->dumpPath)),
            ],
        );
    }

    public function attachments(): array
    {
        if (! $this->attachedDumpPath) {
            return [];
        }

        return [
            Attachment::fromPath($this->attachedDumpPath),
        ];
    }

    private function formatBytes(int $bytes): string
    {
        $units = ['B', 'KB', 'MB', 'GB'];
        $power = $bytes > 0 ? floor(log($bytes, 1024)) : 0;

        return round($bytes / (1024 ** $power), 2).' '.$units[$power];
    }
}
