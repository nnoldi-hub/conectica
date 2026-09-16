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
    <main class="mx-auto max-w-4xl px-4 py-16 sm:px-6 md:py-20 lg:px-8 lg:py-28">
        <a href="{{ route('projects.index') }}" class="text-sm font-medium text-cyan-300 transition hover:text-cyan-200">&lt;- Inapoi la proiecte</a>
        @if ($project->image_path)
            <img loading="lazy" src="{{ Storage::disk('public')->url($project->image_path) }}" alt="{{ $project->title }}" class="mt-8 aspect-video max-h-[300px] w-full rounded-3xl object-cover md:mt-12 md:max-h-none">
        @endif

        @if ($project->client_name || $project->industry)
            <p class="mt-12 text-sm font-semibold uppercase tracking-[0.24em] text-cyan-400 md:mt-16">
                {{ collect([$project->client_name, $project->industry])->filter()->implode(' · ') ?: 'Proiect' }}
            </p>
        @else
            <p class="mt-12 text-sm font-semibold uppercase tracking-[0.24em] text-cyan-400 md:mt-16">Proiect</p>
        @endif
        <h1 class="mt-5 text-3xl font-semibold tracking-tight text-white sm:text-4xl md:text-6xl">{{ $project->title }}</h1>
        <p class="mt-6 text-lg leading-8 text-slate-300 md:mt-8 md:text-xl md:leading-9">{{ $project->summary }}</p>
        <div class="mt-10 flex flex-wrap gap-2">
            @foreach ($project->technologies ?? [] as $technology)
                <span class="rounded-full bg-cyan-400/10 px-4 py-2 text-sm font-medium text-cyan-300">{{ $technology }}</span>
            @endforeach
        </div>
        @if ($project->demo_url || $project->github_url)
            <div class="mt-10 flex flex-wrap gap-4">
                @if ($project->demo_url)
                    <a href="{{ $project->demo_url }}" target="_blank" rel="noreferrer" class="w-full rounded-full bg-cyan-400 px-6 py-3 text-center font-semibold text-slate-950 sm:w-auto">Vezi demo</a>
                @endif
                @if ($project->github_url)
                    <a href="{{ $project->github_url }}" target="_blank" rel="noreferrer" class="w-full rounded-full border border-white/20 px-6 py-3 text-center font-semibold text-white sm:w-auto">Vezi codul</a>
                @endif
            </div>
        @endif

        @if ($project->challenge || $project->solution || $project->results)
            <div class="mt-16 grid gap-6 md:mt-20 md:grid-cols-3">
                @if ($project->challenge)
                    <div class="min-w-0 rounded-3xl border border-white/10 bg-white/[0.04] p-8">
                        <p class="text-sm font-semibold uppercase tracking-[0.2em] text-cyan-400">Provocarea</p>
                        <p class="mt-4 leading-7 text-slate-300">{{ $project->challenge }}</p>
                    </div>
                @endif
                @if ($project->solution)
                    <div class="min-w-0 rounded-3xl border border-white/10 bg-white/[0.04] p-8">
                        <p class="text-sm font-semibold uppercase tracking-[0.2em] text-cyan-400">Solutia</p>
                        <p class="mt-4 leading-7 text-slate-300">{{ $project->solution }}</p>
                    </div>
                @endif
                @if ($project->results)
                    <div class="min-w-0 rounded-3xl border border-cyan-400/30 bg-cyan-400/5 p-8">
                        <p class="text-sm font-semibold uppercase tracking-[0.2em] text-cyan-400">Rezultatul</p>
                        <p class="mt-4 leading-7 text-slate-300">{{ $project->results }}</p>
                    </div>
                @endif
            </div>
        @endif

        @if (! empty($project->gallery))
            <div class="mt-16 md:mt-20">
                <p class="text-sm font-semibold uppercase tracking-[0.2em] text-cyan-400">Galerie</p>
                <div class="mt-6 grid gap-5 sm:grid-cols-2 lg:grid-cols-3" data-gallery>
                    @foreach ($project->gallery as $image)
                        @php $galleryUrl = Storage::disk('public')->url($image); @endphp
                        <button
                            type="button"
                            data-gallery-item
                            data-full="{{ $galleryUrl }}"
                            data-caption="{{ $project->title }} - imagine {{ $loop->iteration }}"
                            class="group relative overflow-hidden rounded-2xl border border-white/10 bg-white/[0.04] text-left shadow-sm transition duration-300 hover:-translate-y-1 hover:shadow-xl hover:shadow-cyan-500/10 focus:outline-none focus-visible:ring-2 focus-visible:ring-cyan-400"
                        >
                            <span class="flex items-center gap-1.5 border-b border-white/10 bg-white/[0.06] px-4 py-2.5">
                                <span class="h-2.5 w-2.5 rounded-full bg-red-400/70"></span>
                                <span class="h-2.5 w-2.5 rounded-full bg-amber-400/70"></span>
                                <span class="h-2.5 w-2.5 rounded-full bg-emerald-400/70"></span>
                            </span>
                            <span class="flex aspect-[4/3] items-center justify-center overflow-hidden bg-slate-950/[0.03] p-3">
                                <img loading="lazy" src="{{ $galleryUrl }}" alt="{{ $project->title }} - imagine {{ $loop->iteration }}" class="h-full w-full object-contain transition duration-300 group-hover:scale-105">
                            </span>
                            <span class="pointer-events-none absolute inset-0 flex items-end justify-end p-3 opacity-0 transition group-hover:opacity-100">
                                <span class="rounded-full bg-slate-950/70 p-2 text-white">
                                    <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M4 8V4h4M16 4h4v4M20 16v4h-4M8 20H4v-4"/>
                                    </svg>
                                </span>
                            </span>
                        </button>
                    @endforeach
                </div>
            </div>

            <div data-lightbox class="fixed inset-0 z-50 hidden items-center justify-center bg-slate-950/90 p-4 backdrop-blur-sm" role="dialog" aria-modal="true" aria-label="Vizualizare galerie">
                <button type="button" data-lightbox-close class="absolute right-4 top-4 rounded-full bg-white/10 p-2 text-white transition hover:bg-white/20" aria-label="Inchide">
                    <svg class="h-6 w-6" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true">
                        <path stroke-linecap="round" d="M6 6l12 12M18 6L6 18"/>
                    </svg>
                </button>
                <button type="button" data-lightbox-prev class="absolute left-2 top-1/2 -translate-y-1/2 rounded-full bg-white/10 p-3 text-white transition hover:bg-white/20 sm:left-6" aria-label="Imaginea anterioara">
                    <svg class="h-6 w-6" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7"/>
                    </svg>
                </button>
                <figure class="max-h-[85vh] max-w-5xl">
                    <img data-lightbox-image src="" alt="" class="max-h-[85vh] w-auto rounded-2xl object-contain shadow-2xl">
                    <figcaption data-lightbox-caption class="mt-4 text-center text-sm text-slate-300"></figcaption>
                </figure>
                <button type="button" data-lightbox-next class="absolute right-2 top-1/2 -translate-y-1/2 rounded-full bg-white/10 p-3 text-white transition hover:bg-white/20 sm:right-6" aria-label="Imaginea urmatoare">
                    <svg class="h-6 w-6" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/>
                    </svg>
                </button>
            </div>
        @endif

        @if ($project->testimonial_quote)
            <blockquote class="mt-16 rounded-3xl border border-white/10 bg-white/[0.04] p-8 md:mt-20 md:p-10">
                <p class="text-xl font-medium leading-8 text-white md:text-2xl md:leading-9">&ldquo;{{ $project->testimonial_quote }}&rdquo;</p>
                @if ($project->testimonial_author)
                    <footer class="mt-6 text-sm font-semibold text-cyan-300">{{ $project->testimonial_author }}</footer>
                @endif
            </blockquote>
        @endif

        <div class="mt-16 flex flex-col items-start gap-4 rounded-3xl border border-cyan-400/30 bg-cyan-400/5 p-8 md:mt-20 sm:flex-row sm:items-center sm:justify-between">
            <p class="text-lg font-semibold text-white">Vrei un proiect construit la fel de atent pentru afacerea ta?</p>
            <a href="{{ route('contact.create') }}" class="w-full rounded-full bg-cyan-400 px-6 py-3 text-center font-semibold text-slate-950 transition hover:bg-cyan-300 sm:w-auto">Pornim o conversatie</a>
        </div>
    </main>
@endsection
