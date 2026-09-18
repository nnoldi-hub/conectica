<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\PostCategory;
use App\Models\Project;
use App\Models\Service;
use App\Models\SocialLink;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\View\View as ViewResponse;

class HomeController extends Controller
{
    public function __invoke(): View
    {
        return view('home', [
            'services' => Service::query()->published()->orderBy('sort_order')->get(),
            'projects' => Project::query()->published()->where('is_featured', true)->orderBy('sort_order')->get(),
            'facebookLink' => SocialLink::published()->where('platform', 'facebook')->first(),
        ]);
    }

    public function services(): ViewResponse
    {
        return view('services.index', [
            'services' => Service::query()->published()->orderBy('sort_order')->get(),
        ]);
    }

    public function service(Service $service): ViewResponse
    {
        abort_unless($service->is_published, Response::HTTP_NOT_FOUND);

        return view('services.show', compact('service'));
    }

    public function projects(): ViewResponse
    {
        return view('projects.index', [
            'projects' => Project::query()->published()->orderBy('sort_order')->get(),
        ]);
    }

    public function project(Project $project): ViewResponse
    {
        abort_unless($project->is_published, Response::HTTP_NOT_FOUND);

        return view('projects.show', compact('project'));
    }

    public function blog(Request $request): ViewResponse
    {
        $categorySlug = $request->string('category')->trim()->toString();
        $selectedCategory = $categorySlug !== ''
            ? PostCategory::query()->where('slug', $categorySlug)->first()
            : null;

        return view('blog.index', [
            'posts' => Post::query()
                ->with('category')
                ->published()
                ->when($selectedCategory, fn ($query) => $query->where('post_category_id', $selectedCategory->id))
                ->latest('published_at')
                ->paginate(9)
                ->withQueryString(),
            'categories' => PostCategory::query()
                ->withCount(['posts' => fn ($query) => $query->published()])
                ->orderBy('name')
                ->get(),
            'selectedCategory' => $selectedCategory,
        ]);
    }

    public function post(Post $post): ViewResponse
    {
        abort_unless($post->is_published && $post->published_at?->isPast(), Response::HTTP_NOT_FOUND);

        $relatedPosts = Post::query()
            ->with('category')
            ->published()
            ->whereKeyNot($post->getKey())
            ->when(
                $post->post_category_id,
                fn ($query) => $query->where('post_category_id', $post->post_category_id),
            )
            ->latest('published_at')
            ->limit(3)
            ->get();

        $searchableText = strtolower($post->title.' '.implode(' ', $post->tags ?? []));
        $serviceSlug = match (true) {
            str_contains($searchableText, 'automat') => 'automatizari',
            str_contains($searchableText, 'erp'),
            str_contains($searchableText, 'crm'),
            str_contains($searchableText, 'digitaliz'),
            str_contains($searchableText, 'excel'),
            str_contains($searchableText, 'santier') => 'produse-software',
            default => 'dezvoltare-web',
        };

        $recommendedService = Service::query()
            ->published()
            ->where('slug', $serviceSlug)
            ->first();

        $recommendedProject = match (true) {
            str_contains($searchableText, 'fleetly'),
            str_contains($searchableText, 'flote') => Project::query()->published()->where('slug', 'fleetly')->first(),
            str_contains($searchableText, 'modulia'),
            str_contains($searchableText, 'construct') => Project::query()->published()->where('slug', 'modulia')->first(),
            default => null,
        };

        return view('blog.show', compact('post', 'relatedPosts', 'recommendedService', 'recommendedProject'));
    }
}
