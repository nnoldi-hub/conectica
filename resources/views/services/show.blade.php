@extends('layouts.public')

@section('title', $service->title.' | Servicii Conectica IT')
@section('description', $service->description)
@section('structured_data')
    {!! json_encode([
        chr(64).'context' => 'https://schema.org',
        chr(64).'type' => 'Service',
        'name' => $service->title,
        'description' => $service->description,
        'url' => route('services.show', $service),
        'provider' => [chr(64).'type' => 'Organization', 'name' => 'Conectica IT', 'url' => route('home')],
        'areaServed' => 'Romania',
    ], JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE) !!}
@endsection

@section('content')
    <main class="mx-auto max-w-5xl px-4 py-16 sm:px-6 md:py-20 lg:px-8 lg:py-28">
        <nav aria-label="Breadcrumb" class="text-sm text-slate-500">
            <a href="{{ route('home') }}" class="transition hover:text-slate-900">Acasa</a>
            <span class="mx-2" aria-hidden="true">/</span>
            <a href="{{ route('services.index') }}" class="transition hover:text-slate-900">Servicii</a>
            <span class="mx-2" aria-hidden="true">/</span>
            <span>{{ $service->title }}</span>
        </nav>

        <div class="mt-12 grid gap-12 lg:grid-cols-[1.2fr_.8fr] lg:items-start">
            <div>
                <p class="text-sm font-semibold uppercase tracking-[0.24em] text-cyan-400">Serviciu</p>
                <h1 class="mt-5 text-4xl font-semibold tracking-tight text-white sm:text-5xl md:text-6xl">{{ $service->title }}</h1>
                <p class="mt-6 text-lg leading-8 text-slate-300">{{ $service->description }}</p>
                <div class="mt-8 flex flex-wrap gap-3">
                    <a href="{{ route('contact.create') }}" data-track-event="cta_click" data-track-target="service_contact" class="inline-flex items-center justify-center rounded-full bg-cyan-700 px-6 py-3 font-semibold text-white transition hover:bg-cyan-800">Discutăm despre proiect</a>
                    <a href="{{ route('services.index') }}" data-track-event="cta_click" data-track-target="service_all" class="inline-flex items-center justify-center rounded-full border border-white/20 px-6 py-3 font-semibold text-white transition hover:border-white/40">Toate serviciile</a>
                </div>
            </div>

            <aside class="rounded-3xl border border-white/10 bg-white/[0.04] p-7">
                <div class="flex h-14 w-14 items-center justify-center rounded-2xl bg-cyan-400/10 text-cyan-300">
                    @svg($service->icon ?: 'heroicon-o-sparkles', 'h-7 w-7')
                </div>
                @if ($service->price_note)
                    <p class="mt-6 text-sm font-semibold text-cyan-300">{{ $service->price_note }}</p>
                @endif
                <p class="mt-3 text-sm leading-6 text-slate-300">Soluția se adaptează obiectivelor, proceselor și nivelului de maturitate al echipei tale.</p>
            </aside>
        </div>

        @if (! empty($service->highlights))
            <section class="mt-16 border-t border-white/10 pt-12" aria-labelledby="service-benefits-title">
                <p class="text-sm font-semibold uppercase tracking-[0.24em] text-cyan-400">Ce primești</p>
                <h2 id="service-benefits-title" class="mt-4 text-3xl font-semibold tracking-tight text-white">Un serviciu construit în jurul rezultatului</h2>
                <ul class="mt-8 grid gap-4 sm:grid-cols-2">
                    @foreach ($service->highlights as $highlight)
                        <li class="rounded-2xl border border-white/10 bg-white/[0.04] p-5 text-slate-300">{{ $highlight }}</li>
                    @endforeach
                </ul>
            </section>
        @endif

        <section class="mt-16 rounded-3xl border border-cyan-900/10 bg-cyan-50 p-7 sm:p-10" aria-labelledby="service-process-title">
            <p class="text-sm font-semibold uppercase tracking-[0.24em] text-cyan-800">Proces</p>
            <h2 id="service-process-title" class="mt-4 text-3xl font-semibold tracking-tight text-slate-950">De la problemă la soluție clară</h2>
            <ol class="mt-8 grid gap-6 md:grid-cols-3">
                <li><strong class="text-cyan-800">01. Înțelegem</strong><p class="mt-2 leading-7 text-slate-700">Clarificăm obiectivele, procesele și blocajele care trebuie rezolvate.</p></li>
                <li><strong class="text-cyan-800">02. Construim</strong><p class="mt-2 leading-7 text-slate-700">Alegem o abordare tehnică potrivită și livrăm incremental, cu feedback real.</p></li>
                <li><strong class="text-cyan-800">03. Evoluăm</strong><p class="mt-2 leading-7 text-slate-700">Măsurăm rezultatul și pregătim soluția pentru următoarea etapă de creștere.</p></li>
            </ol>
        </section>
    </main>
@endsection
