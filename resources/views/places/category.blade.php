@extends('layouts.app')

@php
    $key = request()->route('key');
    $category = App\Services\ContentService::getCategory($key);
    if (!$category) abort(404);
    $places = App\Services\ContentService::getPlacesByCategory($key);
    $categories = App\Services\ContentService::enterpriseCategories();
@endphp

@section('pageTitle', $category['label'] . ' — Каталог підприємств Кропивницького')
@section('pageDescription', $category['description'])

@section('content')
<section class="border-b border-border bg-secondary/40">
    <div class="mx-auto max-w-6xl px-4 py-12 sm:px-6 sm:py-16">
        <nav aria-label="Хлібні крихти" class="flex items-center gap-1.5 text-sm text-muted-foreground">
            <span class="flex items-center gap-1.5">
                <a href="/" class="transition-colors hover:text-foreground">Головна</a>
            </span>
            <span class="flex items-center gap-1.5">
                <svg class="h-3.5 w-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                <a href="{{ route('places.index') }}" class="transition-colors hover:text-foreground">Заклади</a>
            </span>
            <span class="flex items-center gap-1.5">
                <svg class="h-3.5 w-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                <span class="text-foreground">{{ $category['label'] }}</span>
            </span>
        </nav>
        <p class="mt-6 text-sm font-medium text-primary">Каталог підприємств</p>
        <h1 class="mt-2 text-balance font-serif text-4xl font-bold tracking-tight sm:text-5xl">{{ $category['label'] }}</h1>
        <p class="mt-4 max-w-2xl text-pretty text-lg leading-relaxed text-muted-foreground">{{ $category['description'] }}</p>
    </div>
</section>

<div class="mx-auto max-w-6xl px-4 py-12 sm:px-6 sm:py-16">
    <div class="flex flex-wrap items-center gap-3">
        <a href="{{ route('places.index') }}" class="inline-flex items-center gap-1.5 rounded-full border border-border bg-card px-4 py-2 text-sm font-medium text-muted-foreground transition-colors hover:text-foreground">
            <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 12H5M12 19l-7-7 7-7"/></svg>
            Усі категорії
        </a>
        @foreach($categories as $cat)
            @if($cat['key'] !== $key)
                <a href="{{ route('places.category', $cat['key']) }}" class="rounded-full border border-border bg-card px-4 py-2 text-sm font-medium text-muted-foreground transition-colors hover:text-foreground">{{ $cat['label'] }}</a>
            @endif
        @endforeach
    </div>

    <div class="mt-8 flex items-center gap-3">
        <span class="flex h-11 w-11 items-center justify-center rounded-xl bg-primary/10 text-primary">
            @if($category['icon'] === 'UtensilsCrossed')
                <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M3 2v7c0 1.1.9 2 2 2h4a2 2 0 002-2V2M7 2v20M21 15V2v0a5 5 0 00-5 5v6c0 1.1.9 2 2 2h3zm0 0v7"/></svg>
            @elseif($category['icon'] === 'ShoppingBag')
                <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M6 2L3 6v14a2 2 0 002 2h14a2 2 0 002-2V6l-3-4zM3 6h18M16 10a4 4 0 01-8 0"/></svg>
            @elseif($category['icon'] === 'Drama')
                <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><path d="M8 14s1.5 2 4 2 4-2 4-2M9 9h.01M15 9h.01"/></svg>
            @elseif($category['icon'] === 'HeartPulse')
                <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M19.5 12.572l-7.5 7.428l-7.5 -7.428a5 5 0 1 1 7.5 -6.566a5 5 0 1 1 7.5 6.572"/><path d="M12 7l-2 4l4 0l-2 4"/></svg>
            @elseif($category['icon'] === 'GraduationCap')
                <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M22 10l-10-5L2 10l10 5l10-5zM6 12v5c3 3 9 3 12 0v-5"/></svg>
            @elseif($category['icon'] === 'Car')
                <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M14 16H9m10 0h3v-3.15a1 1 0 00-.84-.99L16 11l-2.7-3.6a1 1 0 00-.8-.4H5.24a2 2 0 00-1.8 1.1l-.8 1.63A6 6 0 002 12.42V16h2M7 16a2 2 0 104 0m8 0a2 2 0 10-4 0"/></svg>
            @elseif($category['icon'] === 'Briefcase')
                <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><rect x="2" y="7" width="20" height="14" rx="2"/><path d="M16 7V5a2 2 0 00-2-2h-4a2 2 0 00-2 2v2"/></svg>
            @elseif($category['icon'] === 'Factory')
                <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M2 20V8l5 4V8l5 4V4h8v16H2z"/></svg>
            @endif
        </span>
        <p class="text-sm text-muted-foreground">Підприємств у категорії: <span class="font-semibold text-foreground">{{ count($places) }}</span></p>
    </div>

    @if(count($places) === 0)
        <p class="mt-12 text-center text-muted-foreground">У цій категорії поки немає підприємств.</p>
    @else
        <div class="mt-6 grid gap-6 md:grid-cols-2 lg:grid-cols-3">
            @foreach($places as $place)
                <a href="{{ route('places.show', $place['slug']) }}" class="group overflow-hidden rounded-2xl border border-border bg-card transition-colors hover:border-primary/40">
                    <div class="relative aspect-[16/10] overflow-hidden">
                        <img src="{{ $place['image'] }}" alt="{{ $place['name'] }}" class="h-full w-full object-cover transition-transform duration-500 group-hover:scale-105" loading="lazy" decoding="async">
                        <span class="absolute right-3 top-3 flex items-center gap-1 rounded-full bg-background/90 px-2.5 py-1 text-xs font-semibold backdrop-blur">
                            <svg class="h-3.5 w-3.5 fill-accent text-accent" viewBox="0 0 24 24"><path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/></svg>
                            {{ $place['rating'] }}
                        </span>
                    </div>
                    <div class="p-5">
                        <p class="text-xs font-medium text-primary">{{ $place['category'] }}</p>
                        <h3 class="mt-1.5 font-serif text-lg font-semibold">{{ $place['name'] }}</h3>
                        <p class="mt-2 flex items-center gap-1.5 text-sm text-muted-foreground">
                            <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                            {{ $place['area'] }}
                        </p>
                    </div>
                </a>
            @endforeach
        </div>
    @endif
</div>
@endsection
