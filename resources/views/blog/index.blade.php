@extends('layouts.public')

@section('title', 'Blog tehnic | Conectica IT')
@section('description', 'Articole despre dezvoltare software, automatizari si produse digitale.')
@section('structured_data')
    {!! json_encode([chr(64).'context' => 'https://schema.org', chr(64).'type' => 'CollectionPage', 'name' => 'Blog tehnic Conectica IT', 'url' => route('blog.index')], JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE) !!}
@endsection

@section('content')
    <main class="mx-auto max-w-7xl px-4 py-16 sm:px-6 md:py-20 lg:px-8 lg:py-28">
        <p class="text-sm font-semibold uppercase tracking-[0.24em] text-cyan-400">Blog tehnic</p>
        <h1 class="mt-5 max-w-3xl text-3xl font-semibold tracking-tight text-white sm:text-4xl md:text-6xl">Idei practice pentru produse digitale mai bune.</h1>
        <div class="mt-10 grid gap-6 md:mt-16 md:grid-cols-2 lg:grid-cols-3">
            @forelse ($posts as $post)
                <article class="flex flex-col rounded-3xl border border-white/10 bg-white/[0.04] p-8">
                    @if ($post->image_path)
                        <img loading="lazy" src="{{ Storage::disk('public')->url($post->image_path) }}" alt="{{ $post->title }}" class="mb-8 aspect-video max-h-[300px] w-full rounded-2xl object-cover md:max-h-none">
                    @endif
                    <div class="flex items-center gap-3 text-xs text-slate-400">
                        <time datetime="{{ $post->published_at->toDateString() }}">{{ $post->published_at->format('d.m.Y') }}</time>
                        @if ($post->category)
                            <span class="text-cyan-300">{{ $post->category->name }}</span>
                        @endif
                    </div>
                    <h2 class="mt-8 text-2xl font-semibold text-white">{{ $post->title }}</h2>
                    <p class="mt-4 flex-1 leading-7 text-slate-400">{{ $post->excerpt }}</p>
                    <a href="{{ route('blog.show', $post) }}" class="mt-8 text-sm font-semibold text-white transition hover:text-cyan-300">Citeste articolul <span class="ml-2" aria-hidden="true">-&gt;</span></a>
                </article>
            @empty
                <p class="text-slate-400">Primele articole vor fi publicate in curand.</p>
            @endforelse
        </div>
        @if ($posts->hasPages())
            <div class="mt-12">{{ $posts->links() }}</div>
        @endif
    </main>
@endsection
