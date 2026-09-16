<?php

namespace App\Mail\Concerns;

use Illuminate\Mail\Mailables\Headers;

/**
 * Adds a tracking token header to a Mailable so a queued listener can mark
 * the matching EmailLog row as "sent" once the message actually leaves the
 * queue, and (for mailables that embed the tracking pixel) as "opened".
 */
trait TracksEmailDelivery
{
    public ?string $trackingToken = null;

    public function withTrackingToken(?string $trackingToken): static
    {
        $this->trackingToken = $trackingToken;

        return $this;
    }

    public function headers(): Headers
    {
        return new Headers(
            text: array_filter([
                'X-Tracking-Token' => $this->trackingToken,
            ]),
        );
    }
}
