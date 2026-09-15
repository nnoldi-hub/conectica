@extends('layouts.public')

@section('title', 'Conectica IT | Solutii software construite cu claritate')
@section('description', 'Conectica IT - dezvoltare software, automatizari si solutii digitale construite pentru rezultate reale.')
@section('structured_data')
    {!! json_encode([chr(64).'context' => 'https://schema.org', chr(64).'type' => 'Organization', 'name' => 'Conectica IT', 'url' => route('home')], JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE) !!}
@endsection

@section('content')
        <main>
            <section class="mx-auto grid max-w-7xl gap-8 px-4 pb-16 pt-16 sm:px-6 md:gap-16 md:pt-24 lg:grid-cols-[1.15fr_.85fr] lg:px-8 lg:pb-32 lg:pt-32">
                <div class="flex flex-col justify-center">
                    <p class="mb-6 text-sm font-semibold uppercase tracking-[0.24em] text-cyan-400">Software & automatizari</p>
                    <h1 class="max-w-3xl text-3xl font-semibold tracking-tight text-white sm:text-4xl md:text-5xl lg:text-6xl">
                        Construim solutii digitale care iti simplifica munca.
                    </h1>
                    <p class="mt-6 max-w-2xl text-base leading-7 text-slate-300 md:mt-8 md:text-lg md:leading-8">
                        Dezvoltare web, automatizari si produse software gandite pentru procese mai clare,
                        rezultate masurabile si o baza tehnica pregatita pentru crestere.
                    </p>
                    <div class="mt-8 flex flex-col gap-3 sm:flex-row sm:flex-wrap sm:gap-4 md:mt-10">
                        <a href="{{ route('services.index') }}" class="w-full rounded-full bg-cyan-400 px-6 py-3 text-center font-semibold text-slate-950 transition hover:bg-cyan-300 sm:w-auto">
                            Descopera serviciile
                        </a>
                        <a href="{{ route('contact.create') }}" class="w-full rounded-full border border-white/20 px-6 py-3 text-center font-semibold text-white transition hover:border-white/50 sm:w-auto">
                            Pornim o conversatie
                        </a>
                    </div>
                </div>

                <div class="relative flex items-center justify-center">
                    <div class="absolute h-72 w-72 rounded-full bg-cyan-400/20 blur-3xl"></div>
                    <div class="relative w-full max-w-md rounded-3xl border border-white/10 bg-white/[0.06] p-6 shadow-2xl shadow-cyan-950/40 sm:p-8">
                        <div class="mb-10 flex items-center justify-between text-xs uppercase tracking-[0.2em] text-slate-400 sm:mb-12">
                            <span>Conectica IT</span>
                            <span>01 / 03</span>
                        </div>
                        <div class="space-y-5">
                            <div class="h-3 w-2/3 rounded-full bg-cyan-400/80"></div>
                            <div class="h-3 w-full rounded-full bg-white/10"></div>
                            <div class="h-3 w-5/6 rounded-full bg-white/10"></div>
                        </div>
                        <div class="mt-16 grid grid-cols-2 gap-3">
                            <div class="rounded-2xl border border-white/10 bg-slate-900/70 p-4">
                                <p class="text-2xl font-semibold text-white">clar</p>
                                <p class="mt-1 text-sm text-slate-400">strategie</p>
                            </div>
                            <div class="rounded-2xl border border-white/10 bg-slate-900/70 p-4">
                                <p class="text-2xl font-semibold text-white">scalabil</p>
                                <p class="mt-1 text-sm text-slate-400">arhitectura</p>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

            <section id="servicii" class="border-y border-white/10 bg-slate-900/60">
                <div class="mx-auto max-w-7xl px-4 py-16 sm:px-6 md:py-20 lg:px-8">
                    <p class="text-sm font-semibold uppercase tracking-[0.24em] text-cyan-400">Cu ce te ajutam</p>
                    <div class="mt-8 grid grid-cols-1 gap-6 sm:grid-cols-2 lg:mt-10 lg:grid-cols-3">
                        @foreach ($services as $service)
                            <article class="rounded-2xl border border-white/10 bg-white/[0.04] p-7">
                                <h2 class="text-xl font-semibold text-white">{{ $service->title }}</h2>
                                <p class="mt-4 text-base leading-7 text-slate-400 md:text-lg">{{ $service->description }}</p>
                            </article>
                        @endforeach
                    </div>
                </div>
            </section>

            @if ($projects->isNotEmpty())
                <section class="mx-auto max-w-7xl px-4 py-16 sm:px-6 md:py-20 lg:px-8">
                    <p class="text-sm font-semibold uppercase tracking-[0.24em] text-cyan-400">Proiect in focus</p>
                    <div class="mt-8 grid gap-6 md:grid-cols-2">
                        @foreach ($projects as $project)
                            <article class="rounded-2xl border border-white/10 bg-white/[0.04] p-7">
                                <h2 class="text-2xl font-semibold text-white">{{ $project->title }}</h2>
                                <p class="mt-4 leading-7 text-slate-400">{{ $project->summary }}</p>
                                <div class="mt-6 flex flex-wrap gap-2">
                                    @foreach ($project->technologies ?? [] as $technology)
                                        <span class="rounded-full bg-cyan-400/10 px-3 py-1 text-xs font-medium text-cyan-300">{{ $technology }}</span>
                                    @endforeach
                                </div>
                                <a href="{{ route('projects.show', $project) }}" class="mt-6 inline-flex text-sm font-semibold text-white transition hover:text-cyan-300">Vezi proiectul <span class="ml-2" aria-hidden="true">-&gt;</span></a>
                            </article>
                        @endforeach
                    </div>
                </section>
            @endif
        </main>

@endsection
