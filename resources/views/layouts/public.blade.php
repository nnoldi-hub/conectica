<!DOCTYPE html>
<html lang="ro">
    <head>
        @php
            $pageTitle = trim($__env->yieldContent('title')) ?: 'Conectica IT';
            $pageDescription = trim($__env->yieldContent('description')) ?: 'Conectica IT - dezvoltare software, automatizari si solutii digitale.';
            $pageCanonical = trim($__env->yieldContent('canonical')) ?: url()->current();
            $pageOgImage = trim($__env->yieldContent('og_image')) ?: asset('logo_conectica.png');
        @endphp
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="icon" type="image/png" href="{{ asset('favicon.png') }}">
        <link rel="apple-touch-icon" href="{{ asset('favicon.png') }}">
        <meta name="description" content="{{ $pageDescription }}">
        <link rel="canonical" href="{{ $pageCanonical }}">
        <meta property="og:type" content="@yield('og_type', 'website')">
        <meta property="og:site_name" content="Conectica IT">
        <meta property="og:title" content="@yield('og_title', $pageTitle)">
        <meta property="og:description" content="@yield('og_description', $pageDescription)">
        <meta property="og:url" content="{{ $pageCanonical }}">
        @if ($pageOgImage)
            <meta property="og:image" content="{{ $pageOgImage }}">
        @endif
        <meta name="twitter:card" content="{{ $pageOgImage ? 'summary_large_image' : 'summary' }}">
        @hasSection('structured_data')
            <script type="application/ld+json">@yield('structured_data')</script>
        @endif
        <title>@yield('title', 'Conectica IT')</title>
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="min-h-screen bg-slate-950 text-slate-100 antialiased">
        <header class="border-b border-white/10">
            <div class="mx-auto flex max-w-7xl items-center justify-between px-6 py-5 lg:px-8">
                <a href="{{ route('home') }}" aria-label="Conectica IT - pagina principala" class="flex items-center gap-2">
                    <img src="{{ asset('logo_symbol.png') }}" alt="" aria-hidden="true" class="h-14 w-14 object-contain sm:h-16 sm:w-16">
                    <span class="flex flex-col leading-none">
                        <span class="text-xl font-semibold tracking-tight text-cyan-500 sm:text-2xl">
                            conectica<span class="text-blue-600">-it</span>
                        </span>
                        <span class="mt-1 text-[0.55rem] font-medium tracking-[0.18em] text-slate-500 sm:text-[0.6rem]">
                            Arhitectură. Claritate. Control.
                        </span>
                    </span>
                </a>
                <nav class="hidden items-center gap-6 text-sm text-slate-300 sm:flex">
                    <a href="{{ route('services.index') }}" class="transition hover:text-white">Servicii</a>
                    <a href="{{ route('projects.index') }}" class="transition hover:text-white">Proiecte</a>
                    <a href="{{ route('blog.index') }}" class="transition hover:text-white">Blog</a>
                    <a href="{{ route('contact.create') }}" class="rounded-full border border-cyan-400/40 px-4 py-2 font-medium text-cyan-300 transition hover:border-cyan-300 hover:text-cyan-200">Contact</a>
                </nav>
            </div>
        </header>

        @yield('content')

        <footer id="contact" class="mx-auto flex max-w-7xl flex-col gap-5 px-6 py-10 text-sm text-slate-400 lg:px-8">
            <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
                <p>&copy; {{ date('Y') }} Conectica IT. Toate drepturile rezervate.</p>
                <div class="flex flex-col items-start gap-4 sm:flex-row sm:items-center">
                    @include('partials.social-links')
                    <a href="{{ route('contact.create') }}" class="text-cyan-300 transition hover:text-cyan-200">Trimite o solicitare</a>
                </div>
            </div>
            <nav aria-label="Linkuri legale" class="flex flex-wrap gap-x-5 gap-y-2 border-t border-slate-200 pt-5 text-xs">
                <a href="{{ route('legal.privacy') }}" class="transition hover:text-slate-900">Politica de confidentialitate</a>
                <a href="{{ route('legal.terms') }}" class="transition hover:text-slate-900">Termeni si conditii</a>
                <a href="{{ route('legal.cookies') }}" class="transition hover:text-slate-900">Politica de cookies</a>
            </nav>
        </footer>
    </body>
</html>
