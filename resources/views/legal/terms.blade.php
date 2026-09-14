@extends('layouts.public')

@section('title', 'Termeni si conditii | Conectica IT')
@section('description', 'Termenii de utilizare ai site-ului Conectica IT.')

@section('content')
    <main class="mx-auto max-w-4xl px-6 py-20 lg:px-8 lg:py-28">
        <p class="text-sm font-semibold uppercase tracking-[0.24em] text-cyan-600">Informatii legale</p>
        <h1 class="mt-5 text-4xl font-semibold tracking-tight text-slate-900 sm:text-6xl">Termeni si conditii</h1>
        <div class="mt-10 space-y-8 text-lg leading-8 text-slate-600">
            <p>Folosirea site-ului Conectica IT presupune acceptarea acestor termeni. Continutul este furnizat cu scop informativ si nu reprezinta o oferta contractuala.</p>
            <section>
                <h2 class="text-2xl font-semibold text-slate-900">Continutul site-ului</h2>
                <p class="mt-3">Textele, imaginile, identitatea vizuala si materialele publicate apartin Conectica IT sau sunt folosite cu drept de utilizare. Reproducerea lor fara acord nu este permisa.</p>
            </section>
            <section>
                <h2 class="text-2xl font-semibold text-slate-900">Solicitari si colaborari</h2>
                <p class="mt-3">Trimiterea formularului de contact nu creeaza automat o relatie contractuala. Orice colaborare va fi stabilita separat, printr-o oferta si un acord agreat de parti.</p>
            </section>
            <section>
                <h2 class="text-2xl font-semibold text-slate-900">Disponibilitate</h2>
                <p class="mt-3">Depunem eforturi pentru ca informatiile sa fie corecte si site-ul disponibil, dar nu garantam lipsa intreruperilor sau absenta erorilor.</p>
            </section>
            <p class="border-t border-slate-200 pt-6 text-sm text-slate-500">Acest document este un model informational si trebuie adaptat si verificat juridic inainte de lansarea comerciala.</p>
        </div>
    </main>
@endsection
