@extends('layouts.public')

@section('title', 'Proiecte | Conectica IT')
@section('description', 'Proiecte si solutii software dezvoltate de Conectica IT.')
@section('structured_data')
    {!! json_encode([chr(64).'context' => 'https://schema.org', chr(64).'type' => 'CollectionPage', 'name' => 'Proiecte Conectica IT', 'url' => route('projects.index')], JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE) !!}
@endsection

@section('content')
    <main class="mx-auto max-w-7xl px-4 py-16 sm:px-6 md:py-20 lg:px-8 lg:py-28">
        <p class="text-sm font-semibold uppercase tracking-[0.24em] text-cyan-400">Portofoliu</p>
        <h1 class="mt-5 max-w-3xl text-3xl font-semibold tracking-tight text-white sm:text-4xl md:text-6xl">Proiecte construite cu atentie la detalii.</h1>
        <div class="mt-10 grid gap-6 md:mt-16 md:grid-cols-2">
            @forelse ($projects as $project)
                <article class="min-w-0 rounded-3xl border border-white/10 bg-white/[0.04] p-8 transition hover:border-cyan-400/40">
                    @if ($project->image_path)
                        <img loading="lazy" src="{{ Storage::disk('public')->url($project->image_path) }}" alt="{{ $project->title }}" class="mb-8 aspect-video max-h-[300px] w-full rounded-2xl object-cover md:max-h-none">
                    @endif
                    <p class="text-sm text-cyan-300">{{ str_pad((string) $loop->iteration, 2, '0', STR_PAD_LEFT) }}</p>
                    @if ($project->client_name || $project->industry)
                        <p class="mt-1 text-xs font-medium uppercase tracking-wide text-slate-500">
                            {{ collect([$project->client_name, $project->industry])->filter()->implode(' · ') }}
                        </p>
                    @endif
                    <h2 class="mt-6 text-2xl font-semibold text-white">{{ $project->title }}</h2>
                    <p class="mt-4 max-w-xl leading-7 text-slate-400">{{ $project->summary }}</p>
                    <div class="mt-6 flex flex-wrap gap-2">
                        @foreach ($project->technologies ?? [] as $technology)
                            <span class="rounded-full bg-cyan-400/10 px-3 py-1 text-xs font-medium text-cyan-300">{{ $technology }}</span>
                        @endforeach
                    </div>
                    <a href="{{ route('projects.show', $project) }}" data-track-event="cta_click" data-track-target="projects_list_{{ $project->slug }}" class="mt-8 inline-flex text-sm font-semibold text-white transition hover:text-cyan-300">Vezi proiectul <span class="ml-2" aria-hidden="true">-&gt;</span></a>
                </article>
            @empty
                <p class="text-slate-400">Portofoliul va fi disponibil in curand.</p>
            @endforelse
        </div>
    </main>
@endsection
