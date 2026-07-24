@extends('layouts.app')

@section('meta')
    <x-meta title="Афіша подій — Кропивницький" description="Концерти, вистави, ярмарки та фестивалі міста" image="/images/hero-city.png" />
@endsection

@section('pageTitle', 'Афіша подій — Кропивницький')
@section('pageDescription', 'Концерти, вистави, ярмарки, кіно та фестивалі міста Кропивницький.')

@section('content')
<section class="border-b border-border bg-secondary/40">
    <div class="mx-auto max-w-6xl px-4 py-12 sm:px-6 sm:py-16">
        <x-breadcrumb :items="[['label' => 'Головна', 'href' => '/'], ['label' => 'Афіша']]" />
        <p class="mt-6 text-sm font-medium text-primary">Афіша</p>
        <h1 class="mt-2 text-balance font-serif text-4xl font-bold tracking-tight sm:text-5xl">Найближчі події та розваги</h1>
        <p class="mt-4 max-w-2xl text-pretty text-lg leading-relaxed text-muted-foreground">Концерти, вистави, ярмарки та фестивалі — обирайте, куди піти цими вихідними.</p>
    </div>
</section>

<div class="mx-auto max-w-6xl px-4 py-14 sm:px-6 sm:py-16">
    <div class="grid gap-6 md:grid-cols-2 lg:grid-cols-3">
        @foreach($events as $ev)
            <a href="{{ route('events.show', $ev->slug) }}" class="group overflow-hidden rounded-2xl border border-border bg-card transition-transform hover:-translate-y-1">
                <div class="relative aspect-[3/2] overflow-hidden">
                    @if($ev->image)
                        <img src="{{ $ev->image }}" alt="{{ $ev->title }}" class="h-full w-full object-cover transition-transform duration-500 group-hover:scale-105" loading="lazy" decoding="async">
                    @else
                        <div class="flex h-full w-full items-center justify-center bg-secondary/50">
                            <svg class="h-12 w-12 text-muted-foreground/50" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z"/></svg>
                        </div>
                    @endif
                    <div class="absolute left-3 top-3 flex flex-col items-center rounded-xl bg-background/90 px-3 py-1.5 text-center backdrop-blur">
                        <span class="font-serif text-lg font-bold leading-none">{{ explode(' ', $ev->date)[0] }}</span>
                        <span class="text-[10px] font-medium uppercase tracking-wide text-muted-foreground">{{ explode(' ', $ev->date)[1] ?? '' }}</span>
                    </div>
                    <span class="absolute right-3 top-3 rounded-full bg-accent px-3 py-1 text-xs font-semibold text-accent-foreground">{{ $ev->category }}</span>
                </div>
                <div class="p-5">
                    <h3 class="text-pretty font-serif text-lg font-semibold leading-snug">{{ $ev->title }}</h3>
                    <ul class="mt-4 space-y-2 text-sm text-muted-foreground">
                        <li class="flex items-center gap-2">
                            <svg class="h-4 w-4 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><path d="M12 6v6l4 2"/></svg>
                            {{ $ev->time }}
                        </li>
                        <li class="flex items-center gap-2">
                            <svg class="h-4 w-4 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                            {{ $ev->place }}
                        </li>
                        <li class="flex items-center gap-2">
                            <svg class="h-4 w-4 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M15 5v2m0 4v2m0 4v2M5 5a2 2 0 00-2 2v3a2 2 0 110 4v3a2 2 0 002 2h14a2 2 0 002-2v-3a2 2 0 110-4V7a2 2 0 00-2-2H5z"/></svg>
                            {{ $ev->price }}
                        </li>
                    </ul>
                </div>
            </a>
        @endforeach
    </div>

    <div class="mt-10">
        {{ $events->links() }}
    </div>
</div>
@endsection
