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

    <p class="mt-6 text-sm font-medium text-primary">Пам'ятка міста</p>
    <h1 class="mt-2 text-balance font-serif text-3xl font-bold leading-tight tracking-tight sm:text-4xl">{{ $landmark['title'] }}</h1>

    <div class="mt-8 overflow-hidden rounded-3xl border border-border">
        <img src="{{ $landmark['image'] }}" alt="{{ $landmark['title'] }}" class="aspect-[16/9] w-full object-cover" loading="lazy" decoding="async">
    </div>

    <div class="mt-8 space-y-5 text-lg leading-relaxed text-foreground/90">
        @foreach($landmark['body'] as $paragraph)
            <p class="text-pretty">{{ $paragraph }}</p>
        @endforeach
    </div>
</article>
@endsection
