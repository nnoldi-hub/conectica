@extends('layouts.public')

@section('title', $post->seo_title ?: $post->title)
@section('description', $post->seo_description ?: $post->excerpt)
@section('og_type', 'article')
@if ($post->image_path)
    @section('og_image', Storage::disk('public')->url($post->image_path))
@endif
@section('structured_data')
    {!! json_encode([
        chr(64).'context' => 'https://schema.org',
        chr(64).'type' => 'Article',
        'headline' => $post->title,
        'description' => $post->seo_description ?: $post->excerpt,
        'datePublished' => $post->published_at?->toAtomString(),
        'dateModified' => $post->updated_at?->toAtomString(),
        'url' => route('blog.show', $post),
        'mainEntityOfPage' => [chr(64).'type' => 'WebPage', chr(64).'id' => route('blog.show', $post)],
        'author' => [chr(64).'type' => 'Organization', 'name' => 'Conectica IT', 'url' => route('home')],
        'publisher' => [chr(64).'type' => 'Organization', 'name' => 'Conectica IT', 'url' => route('home')],
        'articleSection' => $post->category?->name,
        'keywords' => $post->tags,
        'wordCount' => str_word_count(strip_tags((string) $post->body)),
        'image' => $post->image_path ? [Storage::disk('public')->url($post->image_path)] : [asset('logo_conectica.png')],
    ], JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE) !!}
@endsection

@section('content')
    <main class="mx-auto max-w-3xl px-4 py-16 sm:px-6 md:py-20 lg:px-8 lg:py-28">
        <nav aria-label="Breadcrumb" class="text-sm text-slate-500">
            <a href="{{ route('home') }}" class="transition hover:text-slate-900">Acasa</a>
            <span class="mx-2" aria-hidden="true">/</span>
            <a href="{{ route('blog.index') }}" class="transition hover:text-slate-900">Blog</a>
            @if ($post->category)
                <span class="mx-2" aria-hidden="true">/</span>
                <span>{{ $post->category->name }}</span>
            @endif
        </nav>
        @if ($post->image_path)
            <img loading="lazy" src="{{ Storage::disk('public')->url($post->image_path) }}" alt="{{ $post->title }}" class="mt-8 aspect-video max-h-[300px] w-full rounded-3xl object-cover md:mt-12 md:max-h-none">
        @endif
        <div class="mt-16 flex flex-wrap items-center gap-x-3 gap-y-2 text-sm text-slate-400">
            <time datetime="{{ $post->published_at->toDateString() }}">{{ $post->published_at->format('d.m.Y') }}</time>
            <span aria-hidden="true">·</span>
            <span>{{ $post->reading_time_minutes }} min de citire</span>
            @if ($post->category)
                <span aria-hidden="true">·</span>
                <span class="text-cyan-300">{{ $post->category->name }}</span>
            @endif
        </div>
        <h1 class="mt-6 text-3xl font-semibold tracking-tight text-white sm:text-4xl md:text-6xl">{{ $post->title }}</h1>
        <p class="mt-6 text-lg leading-8 text-slate-300 md:mt-8 md:text-xl md:leading-9">{{ $post->excerpt }}</p>
        <div class="prose prose-invert post-content mt-12 max-w-none leading-8 text-slate-300">{!! $post->body_html !!}</div>

        @php
            $facebookShareUrl = 'https://www.facebook.com/sharer/sharer.php?u=' . urlencode(route('blog.show', $post)) . '&quote=' . urlencode($post->title . ' | Conectica IT');
        @endphp

        <div class="mt-12 border-t border-white/10 pt-8">
            <p class="text-sm font-semibold uppercase tracking-[0.18em] text-cyan-300">Distribuie articolul</p>
            <div class="mt-4 flex flex-wrap gap-3">
                <a href="{{ $facebookShareUrl }}" data-track-event="facebook_share" target="_blank" rel="noreferrer noopener" class="inline-flex items-center justify-center rounded-full bg-cyan-400 px-4 py-2 text-sm font-semibold text-slate-950 transition hover:bg-cyan-300">
                    Distribuie pe Facebook
                </a>
                <a href="{{ route('blog.index') }}" class="inline-flex items-center justify-center rounded-full border border-white/15 px-4 py-2 text-sm font-semibold text-white transition hover:border-white/30">
                    Înapoi la blog
                </a>
            </div>
        </div>

        <section class="mt-12 rounded-3xl border border-cyan-900/10 bg-cyan-50 p-6 sm:p-8" aria-labelledby="article-cta-title">
            <h2 id="article-cta-title" class="text-2xl font-semibold tracking-tight text-slate-950">Ai o problemă similară în compania ta?</h2>
            <p class="mt-3 max-w-xl leading-7 text-slate-700">Putem analiza procesul actual și construi o soluție digitală clară, potrivită pentru echipa ta.</p>
            <div class="mt-5 flex flex-wrap gap-3">
                <a href="{{ route('contact.create') }}" data-track-event="cta_click" data-track-target="article_contact" class="inline-flex items-center justify-center rounded-full bg-cyan-700 px-5 py-2.5 text-sm font-semibold text-white transition hover:bg-cyan-800">Discutăm despre proiect</a>
                <a href="{{ route('services.index') }}" class="inline-flex items-center justify-center rounded-full border border-cyan-800/20 px-5 py-2.5 text-sm font-semibold text-cyan-900 transition hover:bg-white">Vezi serviciile</a>
            </div>
        </section>

        @if ($relatedPosts->isNotEmpty())
            <section class="mt-12 border-t border-white/10 pt-8" aria-labelledby="related-posts-title">
                <h2 id="related-posts-title" class="text-2xl font-semibold tracking-tight text-white">Articole similare</h2>
                <div class="mt-5 grid gap-4 sm:grid-cols-3">
                    @foreach ($relatedPosts as $relatedPost)
                        <article class="flex min-w-0 flex-col rounded-2xl border border-white/10 bg-white/[0.04] p-5">
                            <p class="text-xs font-semibold uppercase tracking-wide text-cyan-300">{{ $relatedPost->category?->name }}</p>
                            <h3 class="mt-3 text-lg font-semibold text-white">{{ $relatedPost->title }}</h3>
                            <a href="{{ route('blog.show', $relatedPost) }}" class="mt-4 text-sm font-semibold text-cyan-300 transition hover:text-cyan-200">Citește articolul <span aria-hidden="true">-&gt;</span></a>
                        </article>
                    @endforeach
                </div>
            </section>
        @endif

        @if ($post->tags)
            <div class="mt-12 flex flex-wrap gap-2 border-t border-white/10 pt-8">
                @foreach ($post->tags as $tag)
                    <span class="rounded-full bg-cyan-400/10 px-3 py-1 text-xs font-medium text-cyan-300">#{{ $tag }}</span>
                @endforeach
            </div>
        @endif
    </main>
@endsection
