@extends('layouts.app')

@php
    $slug = request()->route('slug');
    $event = App\Services\ContentService::getEvent($slug);
    if (!$event) abort(404);
@endphp

@section('meta')
    <x-meta title="{{ $event['title'] }} — Афіша Кропивницького" description="{{ $event['description'][0] ?? '' }}" type="event" image="{{ $event['image'] }}" />
@endsection

@section('json-ld')
<x-json-ld :schemas="[
    [
        '@context' => 'https://schema.org',
        '@type' => 'Event',
        'name' => $event['title'],
        'startDate' => $event['date'] . 'T' . ($event['time'] ?? '00:00'),
        'location' => [
            '@type' => 'Place',
            'name' => $event['place'] ?? 'Кропивницький',
            'address' => [
                '@type' => 'PostalAddress',
                'addressLocality' => 'Кропивницький',
                'addressCountry' => 'UA',
            ],
        ],
        'offers' => [
            '@type' => 'Offer',
            'price' => $event['price'] ?? '0',
            'priceCurrency' => 'UAH',
            'availability' => 'https://schema.org/InStock',
        ],
        'image' => $event['image'] ? asset($event['image']) : null,
    ],
]" />
@endsection

@section('pageTitle', $event['title'] . ' — Афіша Кропивницького')
@section('pageDescription', $event['description'][0] ?? $event['title'])

@section('content')
<section class="relative">
    <div class="relative h-[42vh] min-h-72 w-full overflow-hidden">
        @if(!empty($event['image']) && file_exists(public_path($event['image'])))
            <img src="{{ $event['image'] }}" alt="{{ $event['title'] }}" class="h-full w-full object-cover" loading="lazy" decoding="async">
        @else
            <div class="flex h-full w-full items-center justify-center bg-secondary/50">
                <svg class="h-16 w-16 text-muted-foreground/50" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z"/></svg>
            </div>
        @endif
        <div class="absolute inset-0 bg-gradient-to-t from-black/80 via-black/30 to-transparent" aria-hidden="true"></div>
        <div class="absolute inset-x-0 bottom-0">
            <div class="mx-auto max-w-6xl px-4 pb-8 sm:px-6">
                <div class="flex items-center gap-2">
                    <span class="rounded-full bg-accent px-3 py-1 text-xs font-semibold text-accent-foreground">{{ $event['category'] }}</span>
                    @if(!empty($event['source']))
                        <span class="rounded-full bg-blue-100 px-3 py-1 text-xs font-medium text-blue-700 dark:bg-blue-900/30 dark:text-blue-300">{{ $event['source'] }}</span>
                    @endif
                </div>
                <h1 class="mt-3 max-w-3xl text-balance font-serif text-3xl font-bold text-white sm:text-5xl">{{ $event['title'] }}</h1>
            </div>
        </div>
    </div>
</section>

<div class="mx-auto max-w-6xl px-4 py-12 sm:px-6 sm:py-16">
    <x-breadcrumb :items="[['label' => 'Головна', 'href' => '/'], ['label' => 'Афіша', 'href' => route('events.index')], ['label' => $event['title']]]" />


    <div class="mt-8 grid gap-10 lg:grid-cols-[1.6fr_1fr]">
        <div class="space-y-5 text-lg leading-relaxed text-foreground/90">
            @foreach($event['description'] as $paragraph)
                <p class="text-pretty">{{ $paragraph }}</p>
            @endforeach
        </div>

        <aside class="h-fit rounded-2xl border border-border bg-card p-6">
            <p class="font-serif text-lg font-semibold">Деталі події</p>
            <dl class="mt-5 space-y-4">
                <div class="flex items-start gap-3">
                    <svg class="mt-0.5 h-5 w-5 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24"><rect x="3" y="4" width="18" height="18" rx="2"/><path d="M16 2v4M8 2v4M3 10h18"/></svg>
                    <div>
                        <dt class="text-xs text-muted-foreground">Дата</dt>
                        <dd class="text-sm font-medium">{{ $event['date'] }}</dd>
                    </div>
                </div>
                <div class="flex items-start gap-3">
                    <svg class="mt-0.5 h-5 w-5 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><path d="M12 6v6l4 2"/></svg>
                    <div>
                        <dt class="text-xs text-muted-foreground">Час</dt>
                        <dd class="text-sm font-medium">{{ $event['time'] }}</dd>
                    </div>
                </div>
                <div class="flex items-start gap-3">
                    <svg class="mt-0.5 h-5 w-5 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                    <div>
                        <dt class="text-xs text-muted-foreground">Місце</dt>
                        <dd class="text-sm font-medium">{{ $event['place'] }}</dd>
                    </div>
                </div>
                <div class="flex items-start gap-3">
                    <svg class="mt-0.5 h-5 w-5 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M15 5v2m0 4v2m0 4v2M5 5a2 2 0 00-2 2v3a2 2 0 110 4v3a2 2 0 002 2h14a2 2 0 002-2v-3a2 2 0 110-4V7a2 2 0 00-2-2H5z"/></svg>
                    <div>
                        <dt class="text-xs text-muted-foreground">Вартість</dt>
                        <dd class="text-sm font-medium">{{ $event['price'] }}</dd>
                    </div>
                </div>
            </dl>
            <button class="mt-6 w-full rounded-full bg-primary px-6 py-3 text-sm font-semibold text-primary-foreground transition-transform hover:scale-[1.02]">Забронювати місце</button>
        </aside>
    </div>
</div>
@endsection
