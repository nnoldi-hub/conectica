@extends('layouts.public')

@section('title', 'Politica de cookies | Conectica IT')
@section('description', 'Informatii despre folosirea cookie-urilor pe site-ul Conectica IT.')

@section('content')
    <main class="mx-auto max-w-4xl px-6 py-20 lg:px-8 lg:py-28">
        <p class="text-sm font-semibold uppercase tracking-[0.24em] text-cyan-600">Informatii legale</p>
        <h1 class="mt-5 text-4xl font-semibold tracking-tight text-slate-900 sm:text-6xl">Politica de cookies</h1>
        <div class="mt-10 space-y-8 text-lg leading-8 text-slate-600">
            <p>Site-ul Conectica IT foloseste cookie-uri strict necesare pentru functionarea aplicatiei si gestionarea sesiunii.</p>
            <section>
                <h2 class="text-2xl font-semibold text-slate-900">Analytics privacy-first</h2>
                <p class="mt-3">Masuram local vizitele si paginile accesate fara stocarea adreselor IP si fara cookie-uri de urmarire. Datele sunt folosite doar pentru intelegerea performantei site-ului.</p>
            </section>
            <section>
                <h2 class="text-2xl font-semibold text-slate-900">Controlul cookie-urilor</h2>
                <p class="mt-3">Poti sterge sau bloca cookie-urile din setarile browserului. Dezactivarea cookie-urilor strict necesare poate afecta autentificarea in zona de administrare.</p>
            </section>
            <section>
                <h2 class="text-2xl font-semibold text-slate-900">Contact</h2>
                <p class="mt-3">Pentru intrebari despre aceasta politica, ne poti scrie la <a class="text-cyan-600 underline" href="mailto:contact@conectica-it.ro">contact@conectica-it.ro</a>.</p>
            </section>
            <p class="border-t border-slate-200 pt-6 text-sm text-slate-500">Politica va fi actualizata daca vom adauga servicii externe de analytics, marketing sau integrari care folosesc cookie-uri.</p>
        </div>
    </main>
@endsection
