@extends('layouts.app')

@php
    $slug = $item->slug;
@endphp

@section('meta')
    <x-meta title="{{ $item['title'] }} — Кропивницький" description="{{ $item['excerpt'] }}" type="article" image="{{ $item['image'] }}" />
@endsection

@section('json-ld')
<x-json-ld :schemas="[
    [
        '@context' => 'https://schema.org',
        '@type' => 'NewsArticle',
        'headline' => $item['title'],
        'datePublished' => $item['date'],
        'author' => [
            '@type' => 'Organization',
            'name' => 'Кропивницький — міський портал',
        ],
        'image' => $item['image'] ? asset($item['image']) : null,
        'publisher' => [
            '@type' => 'Organization',
            'name' => 'Кропивницький — міський портал',
            'logo' => [
                '@type' => 'ImageObject',
                'url' => asset('/images/hero-city.png'),
            ],
        ],
    ],
]" />
@endsection

@section('pageTitle', $item['title'] . ' — Кропивницький')
@section('pageDescription', $item['excerpt'])

@section('content')
<article class="mx-auto max-w-3xl px-4 py-12 sm:px-6 sm:py-16">
    <x-breadcrumb :items="[['label' => 'Головна', 'href' => '/'], ['label' => 'Новини', 'href' => route('news.index')], ['label' => $item['title']]]" />

    <div class="mt-6 flex items-center gap-2">
        <span class="inline-block rounded-full bg-secondary px-3 py-1 text-xs font-medium text-secondary-foreground">{{ $item['tag'] }}</span>
        @if(!empty($item['source']))
            <span class="inline-block rounded-full bg-blue-100 px-3 py-1 text-xs font-medium text-blue-700 dark:bg-blue-900/30 dark:text-blue-300">Джерело: {{ $item['source'] }}</span>
        @endif
    </div>
    <h1 class="mt-4 text-balance font-serif text-3xl font-bold leading-tight tracking-tight sm:text-4xl">{{ $item['title'] }}</h1>
    <div class="mt-4 flex items-center gap-4 text-sm text-muted-foreground">
        <span>{{ $item['date'] }}</span>
        <span class="flex items-center gap-1">
            <svg class="h-3.5 w-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><path d="M12 6v6l4 2"/></svg>
            {{ $item['read'] }} читання
        </span>
    </div>

    <div class="mt-8 overflow-hidden rounded-3xl border border-border">
        <img src="{{ $item['image'] }}" alt="{{ $item['title'] }}" class="aspect-[16/9] w-full object-cover" loading="lazy" decoding="async">
    </div>

    <div class="mt-8 space-y-5 text-lg leading-relaxed text-foreground/90">
        @foreach($item['body'] as $paragraph)
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
