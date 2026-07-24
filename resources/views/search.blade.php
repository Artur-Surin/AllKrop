@extends('layouts.app')

@section('meta')
    <x-meta title="Пошук — Кропивницький" description="Пошук новин, подій, закладів та інформації про місто Кропивницький" :noIndex="true" image="/images/hero-city.png" />
@endsection

@section('pageTitle', 'Пошук — Кропивницький')
@section('pageDescription', 'Пошук новин, подій, закладів та інформації про місто Кропивницький.')

@section('content')
    {{-- Page Header --}}
    <section class="border-b border-border bg-secondary/40">
        <div class="mx-auto max-w-6xl px-4 py-12 sm:px-6 sm:py-16">
            <x-breadcrumb :items="[['label' => 'Головна', 'href' => '/'], ['label' => 'Пошук']]" />

            <p class="mt-6 text-sm font-medium text-primary">Пошук по порталу</p>
            <h1 class="mt-2 text-balance font-serif text-4xl font-bold tracking-tight sm:text-5xl">
                {{ $query ? "Результати за запитом «{$query}»" : 'Пошук по порталу' }}
            </h1>
            <p class="mt-4 max-w-2xl text-pretty text-lg leading-relaxed text-muted-foreground">
                Шукайте серед новин, афіші подій, довідника закладів та інформації про місто.
            </p>
        </div>
    </section>

    {{-- Search --}}
    <section class="mx-auto max-w-3xl px-4 py-14 sm:px-6 sm:py-16">
        <form action="/search" method="GET" role="search" class="relative">
            <svg class="pointer-events-none absolute left-4 top-1/2 h-5 w-5 -translate-y-1/2 text-muted-foreground" fill="none" stroke="currentColor" viewBox="0 0 24 24"><circle cx="11" cy="11" r="8"/><path d="M21 21l-4.35-4.35"/></svg>
            <input type="search" name="q" value="{{ $query }}" placeholder="Пошук новин, подій, закладів..." aria-label="Пошук по сайту" class="w-full rounded-full border border-border bg-card py-3.5 pl-12 pr-28 text-sm text-foreground outline-none transition-colors placeholder:text-muted-foreground focus:border-primary">
            <button type="submit" class="absolute right-1.5 top-1/2 -translate-y-1/2 rounded-full bg-primary px-5 py-2.5 text-sm font-semibold text-primary-foreground transition-transform hover:scale-[1.02]">Знайти</button>
        </form>

        @if($query)
            <p class="mt-6 text-sm text-muted-foreground">
                Знайдено результатів: <span class="font-semibold text-foreground">{{ count($results) }}</span>
            </p>
        @endif

        @if($query && count($results) === 0)
            <div class="mt-10 flex flex-col items-center rounded-3xl border border-border bg-card p-12 text-center">
                <svg class="h-10 w-10 text-muted-foreground" fill="none" stroke="currentColor" viewBox="0 0 24 24"><circle cx="11" cy="11" r="8"/><path d="M21 21l-4.35-4.35"/><path d="M8 11h6"/></svg>
                <h2 class="mt-4 text-lg font-semibold">Нічого не знайдено</h2>
                <p class="mt-2 max-w-sm text-sm leading-relaxed text-muted-foreground">
                    Спробуйте змінити запит або перегляньте розділи порталу — новини, афішу чи довідник закладів.
                </p>
            </div>
        @endif

        <div class="mt-8 space-y-4">
            @foreach($results as $r)
                <a href="{{ $r['href'] }}" class="group flex items-center gap-4 rounded-2xl border border-border bg-card p-4 transition-colors hover:border-primary/40">
                    <div class="h-20 w-24 shrink-0 overflow-hidden rounded-xl">
                        <img src="{{ $r['image'] }}" alt="" class="h-full w-full object-cover transition-transform duration-500 group-hover:scale-105" loading="lazy" decoding="async" width="96" height="80">
                    </div>
                    <div class="min-w-0">
                        <span class="text-xs font-medium text-primary">{{ $r['type'] }}</span>
                        <h3 class="mt-0.5 truncate font-semibold">{{ $r['title'] }}</h3>
                        <p class="mt-1 line-clamp-2 text-sm leading-relaxed text-muted-foreground">{{ $r['excerpt'] }}</p>
                    </div>
                </a>
            @endforeach
        </div>
    </section>
@endsection
