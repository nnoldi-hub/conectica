<?php

namespace App\Providers;

use App\Models\ContactRequest;
use App\Models\Media;
use App\Models\Post;
use App\Models\PostCategory;
use App\Models\Project;
use App\Models\Service;
use App\Models\SocialLink;
use App\Models\User;
use App\Observers\AuditLogObserver;
use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        foreach ([ContactRequest::class, Media::class, Post::class, PostCategory::class, Project::class, Service::class, SocialLink::class, User::class] as $model) {
            $model::observe(AuditLogObserver::class);
        }

        RateLimiter::for('contact', function (Request $request) {
            return Limit::perMinute(3)->by($request->ip());
        });

        View::composer('layouts.public', function ($view): void {
            $view->with('socialLinks', SocialLink::published()->get());
        });
    }
}
