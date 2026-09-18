<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Project;
use App\Models\Service;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Cache;

class SeoController extends Controller
{
    public function sitemap(): Response
    {
        $xml = Cache::remember('seo:sitemap', now()->addHour(), function (): string {
            $urls = [
                ['loc' => route('home')],
                ['loc' => route('services.index')],
                ['loc' => route('projects.index')],
                ['loc' => route('blog.index')],
            ];

            foreach (Service::query()->published()->orderBy('sort_order')->get(['slug', 'updated_at']) as $service) {
                $urls[] = [
                    'loc' => route('services.show', $service),
                    'lastmod' => $service->updated_at,
                ];
            }

            foreach (Project::query()->published()->orderBy('id')->get(['slug', 'updated_at']) as $project) {
                $urls[] = [
                    'loc' => route('projects.show', $project),
                    'lastmod' => $project->updated_at,
                ];
            }

            foreach (Post::query()->published()->orderBy('id')->get(['slug', 'updated_at', 'published_at']) as $post) {
                $urls[] = [
                    'loc' => route('blog.show', $post),
                    'lastmod' => $post->updated_at ?: $post->published_at,
                ];
            }

            return view('seo.sitemap', compact('urls'))->render();
        });

        return response($xml, Response::HTTP_OK)
            ->header('Content-Type', 'application/xml; charset=UTF-8')
            ->header('Cache-Control', 'public, max-age=3600');
    }

    public function robots(): Response
    {
        $content = implode(PHP_EOL, [
            'User-agent: *',
            'Allow: /',
            'Disallow: /admin',
            'Sitemap: '.route('seo.sitemap'),
            '',
        ]);

        return response($content, Response::HTTP_OK)
            ->header('Content-Type', 'text/plain; charset=UTF-8');
    }
}
