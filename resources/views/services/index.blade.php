@extends('layouts.public')

@section('title', 'Servicii | Conectica IT')
@section('description', 'Servicii Conectica IT pentru dezvoltare web, automatizari si produse software.')
@section('structured_data')
    {!! json_encode([chr(64).'context' => 'https://schema.org', chr(64).'type' => 'CollectionPage', 'name' => 'Servicii Conectica IT', 'url' => route('services.index')], JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE) !!}
@endsection

@section('content')
    <main class="mx-auto max-w-7xl px-4 py-16 sm:px-6 md:py-20 lg:px-8 lg:py-28">
        <p class="text-sm font-semibold uppercase tracking-[0.24em] text-cyan-400">Servicii</p>
        <h1 class="mt-5 max-w-3xl text-3xl font-semibold tracking-tight text-white sm:text-4xl md:text-6xl">Tehnologie care lucreaza pentru obiectivele tale.</h1>
        <p class="mt-6 max-w-2xl text-base leading-7 text-slate-300 md:text-lg md:leading-8">Pornim de la problema reala, alegem instrumentele potrivite si livram o solutie pe care o poti folosi si extinde.</p>

        <div class="mt-10 grid gap-6 md:mt-16 md:grid-cols-2 lg:grid-cols-3">
            @forelse ($services as $service)
                <article class="flex min-w-0 flex-col rounded-3xl border border-white/10 bg-white/[0.04] p-8 transition hover:border-cyan-400/40">
                    <div class="flex items-start justify-between">
                        <span class="flex h-14 w-14 items-center justify-center rounded-2xl bg-cyan-400/10 text-cyan-300">
                            @svg($service->icon ?: 'heroicon-o-sparkles', 'h-7 w-7')
                        </span>
                        <span class="text-sm font-medium text-cyan-300">0{{ $loop->iteration }}</span>
                    </div>
                    <h2 class="mt-6 text-2xl font-semibold text-white">{{ $service->title }}</h2>
                    <p class="mt-4 text-base leading-7 text-slate-400 md:text-lg">{{ $service->description }}</p>

                    @if (! empty($service->highlights))
                        <ul class="mt-6 space-y-2">
                            @foreach ($service->highlights as $highlight)
                                <li class="flex items-start gap-2 text-sm text-slate-300">
                                    <svg class="mt-0.5 h-4 w-4 flex-none text-cyan-400" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/>
                                    </svg>
                                    <span>{{ $highlight }}</span>
                                </li>
                            @endforeach
                        </ul>
                    @endif

                    <div class="mt-auto flex flex-col gap-4 pt-8">
                        @if ($service->price_note)
                            <p class="text-sm font-semibold text-cyan-300">{{ $service->price_note }}</p>
                        @endif
                        <a href="{{ route('contact.create') }}" class="inline-flex items-center justify-center rounded-full border border-cyan-400/40 px-5 py-2.5 text-sm font-semibold text-cyan-300 transition hover:border-cyan-300 hover:bg-cyan-400/10 hover:text-cyan-200">
                            Discuta despre acest serviciu
                        </a>
                    </div>
                </article>
            @empty
                <p class="text-slate-400">Serviciile vor fi disponibile in curand.</p>
            @endforelse
        </div>
    </main>
@endsection
