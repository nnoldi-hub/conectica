<?php

use App\Http\Middleware\SecurityHeaders;
use App\Http\Middleware\TrackPageViews;
use App\Models\User;
use App\Notifications\SystemErrorOccurred;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Notification;
use Symfony\Component\HttpKernel\Exception\HttpExceptionInterface;

// Fallback autoloader for packages that could not be installed via
// Composer on hosts where escapeshellarg/escapeshellcmd are disabled
// (Composer cannot run there at all). Only engages when Composer itself
// does not know these packages are installed, so it is a no-op once a
// normal `composer install` succeeds.
if (! class_exists(\Composer\InstalledVersions::class)
    || ! \Composer\InstalledVersions::isInstalled('dompdf/dompdf')) {
    require __DIR__.'/vendor-extra-autoload.php';
}

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        $middleware->web(append: [
            TrackPageViews::class,
            SecurityHeaders::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        $exceptions->shouldRenderJsonWhen(
            fn (Request $request) => $request->is('api/*') || $request->expectsJson(),
        );

        $exceptions->report(function (Throwable $e): void {
            if ($e instanceof HttpExceptionInterface && $e->getStatusCode() < 500) {
                return;
            }

            // Throttle to one notification per unique error per 10 minutes,
            // so a repeating error does not flood the admin panel.
            $throttleKey = 'system-error-notified:'.md5($e::class.$e->getMessage());

            if (Cache::has($throttleKey)) {
                return;
            }

            Cache::put($throttleKey, true, now()->addMinutes(10));

            try {
                Notification::send(
                    User::query()->canAccessAdminPanel()->get(),
                    new SystemErrorOccurred(
                        exceptionClass: $e::class,
                        message: $e->getMessage(),
                        location: $e->getFile().':'.$e->getLine(),
                    ),
                );
            } catch (Throwable) {
                // Never let notification delivery cause a secondary failure.
            }
        });
    })->create();
