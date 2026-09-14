@extends('layouts.public')

@section('title', $project->title . ' | Conectica IT')
@section('description', $project->summary)
@section('og_type', 'article')
@if ($project->image_path)
    @section('og_image', Storage::disk('public')->url($project->image_path))
@endif
@section('structured_data')
    {!! json_encode([chr(64).'context' => 'https://schema.org', chr(64).'type' => 'CreativeWork', 'name' => $project->title, 'description' => $project->summary, 'url' => route('projects.show', $project)], JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE) !!}
@endsection

@section('content')
    <main class="mx-auto max-w-4xl px-6 py-20 lg:px-8 lg:py-28">
        <a href="{{ route('projects.index') }}" class="text-sm font-medium text-cyan-300 transition hover:text-cyan-200">&lt;- Inapoi la proiecte</a>
        @if ($project->image_path)
            <img src="{{ Storage::disk('public')->url($project->image_path) }}" alt="{{ $project->title }}" class="mt-12 aspect-video w-full rounded-3xl object-cover">
        @endif
        <p class="mt-16 text-sm font-semibold uppercase tracking-[0.24em] text-cyan-400">Proiect</p>
        <h1 class="mt-5 text-4xl font-semibold tracking-tight text-white sm:text-6xl">{{ $project->title }}</h1>
        <p class="mt-8 text-xl leading-9 text-slate-300">{{ $project->summary }}</p>
        <div class="mt-10 flex flex-wrap gap-2">
            @foreach ($project->technologies ?? [] as $technology)
                <span class="rounded-full bg-cyan-400/10 px-4 py-2 text-sm font-medium text-cyan-300">{{ $technology }}</span>
            @endforeach
        </div>
        @if ($project->demo_url || $project->github_url)
            <div class="mt-10 flex flex-wrap gap-4">
                @if ($project->demo_url)
                    <a href="{{ $project->demo_url }}" target="_blank" rel="noreferrer" class="rounded-full bg-cyan-400 px-6 py-3 font-semibold text-slate-950">Vezi demo</a>
                @endif
                @if ($project->github_url)
                    <a href="{{ $project->github_url }}" target="_blank" rel="noreferrer" class="rounded-full border border-white/20 px-6 py-3 font-semibold text-white">Vezi codul</a>
                @endif
            </div>
        @endif
    </main>
@endsection
