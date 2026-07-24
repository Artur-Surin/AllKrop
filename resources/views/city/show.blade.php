@extends('layouts.app')

@php
    $slug = request()->route('slug');
    $landmark = App\Services\ContentService::getLandmark($slug);
    if (!$landmark) abort(404);
@endphp

@section('meta')
    <x-meta title="{{ $landmark['title'] }} — Кропивницький" description="{{ $landmark['description'] }}" />
@endsection

@section('pageTitle', $landmark['title'] . ' — Кропивницький')
@section('pageDescription', $landmark['description'])

@section('content')
<article class="mx-auto max-w-3xl px-4 py-12 sm:px-6 sm:py-16">
    <a href="{{ route('city.index') }}" class="inline-flex items-center gap-1.5 text-sm font-medium text-muted-foreground transition-colors hover:text-foreground">
        <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 12H5M12 19l-7-7 7-7"/></svg>
        Про місто
    </a>

    <div class="mt-6">
        @if(isset($landmark['category']) && $landmark['category'])
            <span class="inline-block rounded-full bg-primary/10 px-3 py-1 text-xs font-medium text-primary">
                @if($landmark['category'] === 'theater') Театр
                @elseif($landmark['category'] === 'museum') Музей
                @elseif($landmark['category'] === 'park') Парк
                @elseif($landmark['category'] === 'church') Храм
                @elseif($landmark['category'] === 'history') Історія
                @endif
            </span>
        @endif
        <p class="mt-4 text-sm font-medium text-primary">Пам'ятка міста</p>
        <h1 class="mt-2 text-balance font-serif text-3xl font-bold leading-tight tracking-tight sm:text-4xl">{{ $landmark['title'] }}</h1>
        <p class="mt-3 text-pretty text-lg leading-relaxed text-muted-foreground">{{ $landmark['description'] }}</p>
    </div>

    <div class="mt-8 overflow-hidden rounded-3xl border border-border">
        <img src="{{ $landmark['image'] }}" alt="{{ $landmark['title'] }}" class="aspect-[16/9] w-full object-cover" loading="lazy" decoding="async">
    </div>

    <div class="mt-8 space-y-5 text-lg leading-relaxed text-foreground/90">
        @foreach($landmark['body'] as $paragraph)
            <p class="text-pretty">{{ $paragraph }}</p>
        @endforeach
    </div>

    @if(isset($landmark['address']) || isset($landmark['working_hours']))
        <div class="mt-10 rounded-2xl border border-border bg-card p-6">
            <h2 class="font-serif text-lg font-bold text-foreground">Інформація для відвідувачів</h2>
            <div class="mt-4 space-y-3">
                @if(isset($landmark['address']) && $landmark['address'])
                    <div class="flex items-start gap-3">
                        <svg class="mt-0.5 h-5 w-5 shrink-0 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                        <div>
                            <p class="text-sm font-semibold text-foreground">Адреса</p>
                            <p class="text-sm text-muted-foreground">{{ $landmark['address'] }}</p>
                        </div>
                    </div>
                @endif
                @if(isset($landmark['working_hours']) && $landmark['working_hours'])
                    <div class="flex items-start gap-3">
                        <svg class="mt-0.5 h-5 w-5 shrink-0 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        <div>
                            <p class="text-sm font-semibold text-foreground">Графік роботи</p>
                            <p class="text-sm text-muted-foreground">{{ $landmark['working_hours'] }}</p>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    @endif

    <div class="mt-10 flex items-center justify-between rounded-2xl border border-border bg-card p-4">
        <a href="{{ route('city.index') }}" class="inline-flex items-center gap-1.5 text-sm font-medium text-muted-foreground transition-colors hover:text-foreground">
            <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 12H5M12 19l-7-7 7-7"/></svg>
            Усі пам'ятки
        </a>
        <a href="/" class="inline-flex items-center gap-1.5 text-sm font-medium text-muted-foreground transition-colors hover:text-foreground">
            На головну
            <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 12h14M12 5l7 7-7 7"/></svg>
        </a>
    </div>
</article>
@endsection
