@extends('layouts.public')

@section('title', $post->seo_title ?: $post->title)
@section('description', $post->seo_description ?: $post->excerpt)
@section('og_type', 'article')
@if ($post->image_path)
    @section('og_image', Storage::disk('public')->url($post->image_path))
@endif
@section('structured_data')
    {!! json_encode([chr(64).'context' => 'https://schema.org', chr(64).'type' => 'Article', 'headline' => $post->title, 'description' => $post->excerpt, 'datePublished' => $post->published_at?->toAtomString(), 'dateModified' => $post->updated_at?->toAtomString(), 'url' => route('blog.show', $post)], JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE) !!}
@endsection

@section('content')
    <main class="mx-auto max-w-3xl px-4 py-16 sm:px-6 md:py-20 lg:px-8 lg:py-28">
        <a href="{{ route('blog.index') }}" class="text-sm font-medium text-cyan-300 transition hover:text-cyan-200">&lt;- Inapoi la blog</a>
        @if ($post->image_path)
            <img loading="lazy" src="{{ Storage::disk('public')->url($post->image_path) }}" alt="{{ $post->title }}" class="mt-8 aspect-video max-h-[300px] w-full rounded-3xl object-cover md:mt-12 md:max-h-none">
        @endif
        <div class="mt-16 flex items-center gap-3 text-sm text-slate-400">
            <time datetime="{{ $post->published_at->toDateString() }}">{{ $post->published_at->format('d.m.Y') }}</time>
            @if ($post->category)
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
                <a href="{{ $facebookShareUrl }}" target="_blank" rel="noreferrer noopener" class="inline-flex items-center justify-center rounded-full bg-cyan-400 px-4 py-2 text-sm font-semibold text-slate-950 transition hover:bg-cyan-300">
                    Distribuie pe Facebook
                </a>
                <a href="{{ route('blog.index') }}" class="inline-flex items-center justify-center rounded-full border border-white/15 px-4 py-2 text-sm font-semibold text-white transition hover:border-white/30">
                    Înapoi la blog
                </a>
            </div>
        </div>

        @if ($post->tags)
            <div class="mt-12 flex flex-wrap gap-2 border-t border-white/10 pt-8">
                @foreach ($post->tags as $tag)
                    <span class="rounded-full bg-cyan-400/10 px-3 py-1 text-xs font-medium text-cyan-300">#{{ $tag }}</span>
                @endforeach
            </div>
        @endif
    </main>
@endsection
