<?php

namespace App\Http\Controllers;

use App\Models\ConversionEvent;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ConversionEventController extends Controller
{
    public function store(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'event_name' => ['required', 'string', 'in:cta_click,contact_submitted,facebook_share'],
            'target' => ['nullable', 'string', 'max:255'],
        ]);

        ConversionEvent::query()->create([
            'event_name' => $validated['event_name'],
            'path' => substr('/'.ltrim($request->path(), '/'), 0, 255),
            'target' => $validated['target'] ?? null,
            'referrer_host' => $this->referrerHost($request->headers->get('referer')),
            'occurred_at' => now(),
        ]);

        return response()->json(['tracked' => true], 201);
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
