<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Project;
use App\Models\Service;
use App\Models\SocialLink;
use Illuminate\Contracts\View\View;
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

    public function blog(): ViewResponse
    {
        return view('blog.index', [
            'posts' => Post::query()->with('category')->published()->latest('published_at')->paginate(9),
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

        return view('blog.show', compact('post', 'relatedPosts'));
    }
}
