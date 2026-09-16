<?php

namespace App\Mail;

use App\Mail\Concerns\TracksEmailDelivery;
use App\Models\ContactRequest;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class ContactRequestConfirmation extends Mailable
{
    use Queueable, SerializesModels, TracksEmailDelivery;

    public function __construct(public ContactRequest $contactRequest) {}

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Am primit mesajul tau - Conectica IT',
            replyTo: [
                config('mail.notifications_email'),
            ],
        );
    }

    public function content(): Content
    {
        return new Content(
            markdown: 'mail.contact-request-confirmation',
            with: [
                'trackingToken' => $this->trackingToken,
            ],
        );
    }
}
