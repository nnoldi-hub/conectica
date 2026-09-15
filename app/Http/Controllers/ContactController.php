<?php

namespace App\Http\Controllers;

use App\Mail\ContactRequestReceived;
use App\Models\ContactRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
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
        if ($request->filled('company_website') || $this->looksLikeSpam($request->string('form_rendered_at')->toString())) {
            Log::info('Contact form submission blocked as suspected spam.', [
                'ip' => $request->ip(),
                'honeypot_filled' => $request->filled('company_website'),
                'honeypot_value' => $request->input('company_website'),
                'form_rendered_at_raw' => $request->input('form_rendered_at'),
                'elapsed_seconds' => $this->debugElapsedSeconds($request->string('form_rendered_at')->toString()),
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

        Mail::to(config('mail.notifications_email'))->queue(new ContactRequestReceived($contactRequest));

        return to_route('contact.create')->with('contact_sent', 'Multumim! Mesajul tau a fost trimis.');
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

    /**
     * Temporary diagnostic helper: returns the elapsed seconds (or null if
     * decryption failed) so we can log it without duplicating the try/catch.
     */
    private function debugElapsedSeconds(string $encryptedRenderedAt): ?float
    {
        try {
            $renderedAt = (float) Crypt::decryptString($encryptedRenderedAt);
        } catch (\Exception) {
            return null;
        }

        return microtime(true) - $renderedAt;
    }
}
