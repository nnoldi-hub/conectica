<?php

namespace App\Http\Controllers;

use App\Mail\ContactRequestReceived;
use App\Models\ContactRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\View\View;

class ContactController extends Controller
{
    public function create(): View
    {
        return view('contact');
    }

    public function store(Request $request): RedirectResponse
    {
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

        Mail::to(config('contact.notifications_email'))->queue(new ContactRequestReceived($contactRequest));

        return to_route('contact.create')->with('contact_sent', 'Multumim! Mesajul tau a fost trimis.');
    }
}
