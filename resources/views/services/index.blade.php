@extends('layouts.public')

@section('title', 'Servicii | Conectica IT')
@section('description', 'Servicii Conectica IT pentru dezvoltare web, automatizari si produse software.')
@section('structured_data')
    {!! json_encode([chr(64).'context' => 'https://schema.org', chr(64).'type' => 'CollectionPage', 'name' => 'Servicii Conectica IT', 'url' => route('services.index')], JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE) !!}
@endsection

@section('content')
    <main class="mx-auto max-w-7xl px-6 py-20 lg:px-8 lg:py-28">
        <p class="text-sm font-semibold uppercase tracking-[0.24em] text-cyan-400">Servicii</p>
        <h1 class="mt-5 max-w-3xl text-4xl font-semibold tracking-tight text-white sm:text-6xl">Tehnologie care lucreaza pentru obiectivele tale.</h1>
        <p class="mt-6 max-w-2xl text-lg leading-8 text-slate-300">Pornim de la problema reala, alegem instrumentele potrivite si livram o solutie pe care o poti folosi si extinde.</p>

        <div class="mt-16 grid gap-6 md:grid-cols-2 lg:grid-cols-3">
            @forelse ($services as $service)
                <article class="rounded-3xl border border-white/10 bg-white/[0.04] p-8">
                    <span class="text-sm font-medium text-cyan-300">0{{ $loop->iteration }}</span>
                    <h2 class="mt-10 text-2xl font-semibold text-white">{{ $service->title }}</h2>
                    <p class="mt-4 leading-7 text-slate-400">{{ $service->description }}</p>
                </article>
            @empty
                <p class="text-slate-400">Serviciile vor fi disponibile in curand.</p>
            @endforelse
        </div>
    </main>
@endsection
