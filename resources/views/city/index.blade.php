@extends('layouts.app')

@section('meta')
    <x-meta title="Про місто — Кропивницький" description="Історія, пам'ятки та туристичний гід міста" />
@endsection

@section('pageTitle', 'Про місто — Кропивницький')
@section('pageDescription', 'Історія, пам\u2019ятки та туристичний гід міста Кропивницький у Центральній Україні.')

@section('content')
<section class="border-b border-border bg-secondary/40">
    <div class="mx-auto max-w-6xl px-4 py-12 sm:px-6 sm:py-16">
        <nav aria-label="Хлібні крихти" class="flex items-center gap-1.5 text-sm text-muted-foreground">
            <span class="flex items-center gap-1.5">
                <a href="/" class="transition-colors hover:text-foreground">Головна</a>
            </span>
            <span class="flex items-center gap-1.5">
                <svg class="h-3.5 w-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                <span class="text-foreground">Місто</span>
            </span>
        </nav>
        <p class="mt-6 text-sm font-medium text-primary">Про місто</p>
        <h1 class="mt-2 text-balance font-serif text-4xl font-bold tracking-tight sm:text-5xl">Кропивницький — місто, яке варто відкрити</h1>
        <p class="mt-4 max-w-2xl text-pretty text-lg leading-relaxed text-muted-foreground">Розташований у самому серці України, Кропивницький поєднує багату театральну спадщину, зелені парки та затишну атмосферу провінційного міста.</p>
    </div>
</section>

@php
    $stats = App\Services\ContentService::stats();
    $landmarks = App\Services\ContentService::landmarks();
@endphp

<section class="mx-auto max-w-6xl px-4 py-14 sm:px-6 sm:py-16">
    <dl class="grid grid-cols-2 gap-6 rounded-3xl border border-border bg-card p-8 sm:grid-cols-4">
        @foreach($stats as $s)
            <div>
                <dt class="sr-only">{{ $s['label'] }}</dt>
                <dd class="font-serif text-3xl font-bold text-foreground sm:text-4xl">{{ $s['value'] }}</dd>
                <p class="mt-1 text-xs leading-snug text-muted-foreground">{{ $s['label'] }}</p>
            </div>
        @endforeach
    </dl>

    <div class="mt-14">
        <p class="text-sm font-medium text-primary">Туристичний гід</p>
        <h2 class="mt-2 text-balance font-serif text-3xl font-bold tracking-tight sm:text-4xl">Що подивитися в місті</h2>
    </div>

    <div class="mt-8 grid gap-6 lg:grid-cols-2">
        @foreach($landmarks as $item)
            <a href="{{ route('city.show', $item['slug']) }}" class="group relative overflow-hidden rounded-3xl border border-border">
                <div class="relative aspect-[16/10]">
                    <img src="{{ $item['image'] }}" alt="{{ $item['title'] }}" class="h-full w-full object-cover transition-transform duration-700 group-hover:scale-105" loading="lazy" decoding="async">
                    <div class="absolute inset-0 bg-gradient-to-t from-black/80 via-black/20 to-transparent" aria-hidden="true"></div>
                    <div class="absolute inset-x-0 bottom-0 p-6 sm:p-8">
                        <h3 class="text-balance font-serif text-2xl font-bold text-white sm:text-3xl">{{ $item['title'] }}</h3>
                        <p class="mt-2 max-w-md text-pretty text-sm leading-relaxed text-white/80">{{ $item['description'] }}</p>
                        <span class="mt-4 inline-flex items-center gap-1.5 text-sm font-semibold text-white">
                            Дізнатися більше
                            <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg>
                        </span>
                    </div>
                </div>
            </a>
        @endforeach
    </div>
</section>
@endsection
