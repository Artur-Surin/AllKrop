@extends('layouts.app')

@php
    $slug = request()->route('slug');
    $article = App\Services\ContentService::getNews($slug);
    if (!$article) abort(404);
    $allNews = App\Services\ContentService::news();
    $related = array_values(array_filter($allNews, fn($n) => $n['slug'] !== $slug));
    $related = array_slice($related, 0, 2);
@endphp

@section('meta')
    <x-meta title="{{ $article['title'] }} — Кропивницький" description="{{ $article['excerpt'] }}" type="article" />
@endsection

@section('pageTitle', $article['title'] . ' — Кропивницький')
@section('pageDescription', $article['excerpt'])

@section('content')
<article class="mx-auto max-w-3xl px-4 py-12 sm:px-6 sm:py-16">
    <a href="{{ route('news.index') }}" class="inline-flex items-center gap-1.5 text-sm font-medium text-muted-foreground transition-colors hover:text-foreground">
        <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 12H5M12 19l-7-7 7-7"/></svg>
        Усі новини
    </a>

    <span class="mt-6 inline-block rounded-full bg-secondary px-3 py-1 text-xs font-medium text-secondary-foreground">{{ $article['tag'] }}</span>
    <h1 class="mt-4 text-balance font-serif text-3xl font-bold leading-tight tracking-tight sm:text-4xl">{{ $article['title'] }}</h1>
    <div class="mt-4 flex items-center gap-4 text-sm text-muted-foreground">
        <span>{{ $article['date'] }}</span>
        <span class="flex items-center gap-1">
            <svg class="h-3.5 w-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><path d="M12 6v6l4 2"/></svg>
            {{ $article['read'] }} читання
        </span>
    </div>

    <div class="mt-8 overflow-hidden rounded-3xl border border-border">
        <img src="{{ $article['image'] }}" alt="{{ $article['title'] }}" class="aspect-[16/9] w-full object-cover" loading="lazy" decoding="async">
    </div>

    <div class="mt-8 space-y-5 text-lg leading-relaxed text-foreground/90">
        @foreach($article['body'] as $paragraph)
            <p class="text-pretty">{{ $paragraph }}</p>
        @endforeach
    </div>
</article>

@if(count($related) > 0)
<section class="border-t border-border bg-secondary/40">
    <div class="mx-auto max-w-6xl px-4 py-14 sm:px-6">
        <h2 class="font-serif text-2xl font-bold tracking-tight">Читайте також</h2>
        <div class="mt-6 grid gap-5 sm:grid-cols-2">
            @foreach($related as $item)
                <a href="{{ route('news.show', $item['slug']) }}" class="group flex gap-4 rounded-2xl border border-border bg-card p-4 transition-colors hover:border-primary/40">
                    <img src="{{ $item['image'] }}" alt="{{ $item['title'] }}" class="h-20 w-24 shrink-0 rounded-xl object-cover" loading="lazy" decoding="async" width="96" height="80">
                    <div>
                        <p class="text-xs font-medium text-primary">{{ $item['tag'] }}</p>
                        <h3 class="mt-1 text-pretty font-serif text-base font-semibold leading-snug">{{ $item['title'] }}</h3>
                    </div>
                </a>
            @endforeach
        </div>
    </div>
</section>
@endif
@endsection
