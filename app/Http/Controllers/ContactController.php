<?php

namespace App\Http\Controllers;

use App\Mail\ContactRequestConfirmation;
use App\Mail\ContactRequestReceived;
use App\Models\ContactRequest;
use App\Models\ConversionEvent;
use App\Models\EmailLog;
use App\Models\User;
use App\Notifications\NewContactRequestReceived;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Str;
use Illuminate\View\View;

class ContactController extends Controller
{
    public function create(): View
    {
        return view('contact', [
            'formRenderedAt' => Crypt::encryptString((string) microtime(true)),
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        if ($request->filled('hp_field_9k2x') || $this->looksLikeSpam($request->string('form_rendered_at')->toString())) {
            Log::info('Contact form submission blocked as suspected spam.', [
                'ip' => $request->ip(),
            ]);

            return to_route('contact.create')->with('contact_sent', 'Multumim! Mesajul tau a fost trimis.');
        }

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:120'],
            'email' => ['required', 'email:rfc', 'max:255'],
            'phone' => ['nullable', 'string', 'max:30'],
            'service' => ['nullable', 'string', 'max:120'],
            'budget' => ['nullable', 'string', 'max:80'],
            'message' => ['required', 'string', 'min:20', 'max:5000'],
            'privacy_accepted' => ['accepted'],
        ]);

        unset($validated['privacy_accepted']);
        $contactRequest = ContactRequest::query()->create($validated);
        ConversionEvent::query()->create([
            'event_name' => 'contact_submitted',
            'path' => '/contact',
            'target' => 'contact_form',
            'referrer_host' => $this->referrerHost($request->headers->get('referer')),
            'occurred_at' => now(),
        ]);

        $this->sendTracked(
            mailable: new ContactRequestReceived($contactRequest),
            to: config('mail.notifications_email'),
            subject: 'Solicitare noua de contact de la '.$contactRequest->name,
            contactRequest: $contactRequest,
        );

        $this->sendTracked(
            mailable: new ContactRequestConfirmation($contactRequest),
            to: $contactRequest->email,
            subject: 'Am primit mesajul tau - Conectica IT',
            contactRequest: $contactRequest,
        );

        Notification::send(
            User::query()->canAccessAdminPanel()->get(),
            new NewContactRequestReceived($contactRequest),
        );

        return to_route('contact.create')->with('contact_sent', 'Multumim! Mesajul tau a fost trimis.');
    }

    /**
     * Queue a trackable mailable and record it in the email log so it can be
     * followed up in the admin "Comunicare" section (sent / opened status).
     */
    private function sendTracked(object $mailable, string $to, string $subject, ContactRequest $contactRequest): void
    {
        if (trim($to) === '') {
            Log::error('Nu s-a putut trimite emailul: adresa destinatarului este goala.', [
                'mailable' => $mailable::class,
                'contact_request_id' => $contactRequest->id,
            ]);

            return;
        }

        $token = (string) Str::uuid();

        EmailLog::query()->create([
            'contact_request_id' => $contactRequest->id,
            'mailable' => $mailable::class,
            'to_email' => $to,
            'subject' => $subject,
            'status' => 'queued',
            'tracking_token' => $token,
        ]);

        if (method_exists($mailable, 'withTrackingToken')) {
            $mailable->withTrackingToken($token);
        }

        Mail::to($to)->queue($mailable);
    }

    private function looksLikeSpam(string $encryptedRenderedAt): bool
    {
        try {
            $renderedAt = (float) Crypt::decryptString($encryptedRenderedAt);
        } catch (\Exception) {
            return true;
        }

        $elapsed = microtime(true) - $renderedAt;

        return $elapsed < 3 || $elapsed > 3600;
    }

    private function referrerHost(?string $referrer): ?string
    {
        if (! $referrer) {
            return null;
        }

        $host = parse_url($referrer, PHP_URL_HOST);

        return is_string($host) ? substr($host, 0, 255) : null;
    }
}
