<?php

namespace App\Http\Middleware;

use App\Models\PageView;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class TrackPageViews
{
    public function handle(Request $request, Closure $next): Response
    {
        $response = $next($request);

        if ($request->isMethod('GET') && $response->isSuccessful() && $request->routeIs('home', 'services.*', 'projects.*', 'blog.*', 'contact.*')) {
            PageView::query()->create([
                'path' => substr('/'.ltrim($request->path(), '/'), 0, 255),
                'referrer_host' => $this->referrerHost($request->headers->get('referer')),
                'viewed_at' => now(),
            ]);
        }

        return $response;
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
