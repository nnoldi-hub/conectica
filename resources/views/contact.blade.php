@extends('layouts.public')

@section('title', 'Contact | Conectica IT')
@section('description', 'Trimite-ne detaliile proiectului tau si revenim cu o discutie clara despre urmatorii pasi.')

@section('content')
    <main class="mx-auto grid max-w-7xl gap-10 px-4 py-16 sm:px-6 md:gap-16 md:py-20 lg:grid-cols-[.8fr_1.2fr] lg:px-8 lg:py-28">
        <div>
            <p class="text-sm font-semibold uppercase tracking-[0.24em] text-cyan-400">Contact</p>
            <h1 class="mt-5 text-3xl font-semibold tracking-tight text-white sm:text-4xl md:text-6xl">Hai sa discutam despre urmatorul tau proiect.</h1>
            <p class="mt-6 text-base leading-7 text-slate-300 md:text-lg md:leading-8">Trimite cateva detalii, iar noi revenim cu intrebari clare si o directie potrivita pentru obiectivul tau.</p>
        </div>
        <div class="rounded-3xl border border-white/10 bg-white/[0.04] p-8 sm:p-10">
            @if (session('contact_sent'))
                <div class="mb-8 rounded-2xl border border-emerald-400/30 bg-emerald-400/10 p-4 text-emerald-200">{{ session('contact_sent') }}</div>
            @endif
            <form method="POST" action="{{ route('contact.store') }}" class="space-y-6">
                @csrf
                <input type="hidden" name="form_rendered_at" value="{{ $formRenderedAt }}">
                <div aria-hidden="true" style="display:none;" tabindex="-1">
                    <label for="hp_field_9k2x">Nu completa acest camp</label>
                    <input type="text" id="hp_field_9k2x" name="hp_field_9k2x" tabindex="-1" autocomplete="off">
                </div>
                <div class="grid gap-6 sm:grid-cols-2">
                    <div>
                        <label for="name" class="text-sm font-medium text-slate-200">Nume *</label>
                        <input id="name" name="name" value="{{ old('name') }}" required class="mt-2 w-full rounded-xl border border-white/10 bg-slate-950 px-4 py-3 text-white outline-none focus:border-cyan-400" />
                        @error('name')<p class="mt-2 text-sm text-red-300">{{ $message }}</p>@enderror
                    </div>
                    <div>
                        <label for="email" class="text-sm font-medium text-slate-200">Email *</label>
                        <input id="email" name="email" type="email" value="{{ old('email') }}" required class="mt-2 w-full rounded-xl border border-white/10 bg-slate-950 px-4 py-3 text-white outline-none focus:border-cyan-400" />
                        @error('email')<p class="mt-2 text-sm text-red-300">{{ $message }}</p>@enderror
                    </div>
                </div>
                <div class="grid gap-6 sm:grid-cols-2">
                    <div>
                        <label for="phone" class="text-sm font-medium text-slate-200">Telefon</label>
                        <input id="phone" name="phone" value="{{ old('phone') }}" class="mt-2 w-full rounded-xl border border-white/10 bg-slate-950 px-4 py-3 text-white outline-none focus:border-cyan-400" />
                    </div>
                    <div>
                        <label for="service" class="text-sm font-medium text-slate-200">Serviciu</label>
                        <select id="service" name="service" class="mt-2 w-full rounded-xl border border-white/10 bg-slate-950 px-4 py-3 text-white outline-none focus:border-cyan-400">
                            <option value="">Alege o optiune</option>
                            <option value="Dezvoltare web">Dezvoltare web</option>
                            <option value="Automatizari">Automatizari</option>
                            <option value="Produs software">Produs software</option>
                        </select>
                    </div>
                </div>
                <div>
                    <label for="budget" class="text-sm font-medium text-slate-200">Buget estimativ</label>
                    <select id="budget" name="budget" class="mt-2 w-full rounded-xl border border-white/10 bg-slate-950 px-4 py-3 text-white outline-none focus:border-cyan-400">
                        <option value="">Prefer sa discutam</option>
                        <option value="Sub 2.000 EUR">Sub 2.000 EUR</option>
                        <option value="2.000 - 5.000 EUR">2.000 - 5.000 EUR</option>
                        <option value="Peste 5.000 EUR">Peste 5.000 EUR</option>
                    </select>
                </div>
                <div>
                    <label for="message" class="text-sm font-medium text-slate-200">Mesaj *</label>
                    <textarea id="message" name="message" rows="6" required class="mt-2 w-full rounded-xl border border-white/10 bg-slate-950 px-4 py-3 text-white outline-none focus:border-cyan-400">{{ old('message') }}</textarea>
                    @error('message')<p class="mt-2 text-sm text-red-300">{{ $message }}</p>@enderror
                </div>
                <label class="flex items-start gap-3 text-sm text-slate-400">
                    <input type="checkbox" name="privacy_accepted" value="1" required class="mt-1 accent-cyan-400">
                    <span>Sunt de acord ca datele trimise sa fie folosite pentru a raspunde solicitarii mele, conform <a href="{{ route('legal.privacy') }}" target="_blank" rel="noreferrer" class="text-cyan-600 underline hover:text-cyan-500">Politicii de confidentialitate</a>.</span>
                </label>
                @error('privacy_accepted')<p class="text-sm text-red-300">{{ $message }}</p>@enderror
                <button type="submit" class="w-full rounded-full bg-cyan-400 px-6 py-3 font-semibold text-slate-950 transition hover:bg-cyan-300">Trimite solicitarea</button>
            </form>
        </div>
    </main>
@endsection
