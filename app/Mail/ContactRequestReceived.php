<?php

namespace App\Mail;

use App\Filament\Resources\ContactRequests\ContactRequestResource;
use App\Mail\Concerns\TracksEmailDelivery;
use App\Models\ContactRequest;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Address;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class ContactRequestReceived extends Mailable
{
    use Queueable, SerializesModels, TracksEmailDelivery;

    public function __construct(public ContactRequest $contactRequest) {}

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Solicitare noua de contact de la '.$this->contactRequest->name,
            replyTo: [
                new Address($this->contactRequest->email, $this->contactRequest->name),
            ],
        );
    }

    public function content(): Content
    {
        return new Content(
            markdown: 'mail.contact-request-received',
            with: [
                'adminUrl' => ContactRequestResource::getUrl('edit', ['record' => $this->contactRequest]),
            ],
        );
    }
}
