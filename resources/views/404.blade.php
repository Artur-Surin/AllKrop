@extends('layouts.app')

@section('pageTitle', 'Сторінку не знайдено — 404 — Кропивницький')
@section('pageDescription', 'Сторінку не знайдено. Перейдіть на головну сторінку порталу.')

@section('content')
<section class="mx-auto flex max-w-2xl flex-col items-center px-4 py-24 text-center sm:px-6 sm:py-32">
    <span class="flex h-14 w-14 items-center justify-center rounded-2xl bg-primary/10 text-primary">
        <svg class="h-7 w-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><path d="M12 2a14.5 14.5 0 000 20 14.5 14.5 0 000-20"/><path d="M2 12h20"/></svg>
    </span>
    <p class="mt-8 font-serif text-6xl font-bold text-primary sm:text-7xl">404</p>
    <h1 class="mt-4 text-balance font-serif text-3xl font-bold tracking-tight sm:text-4xl">Сторінку не знайдено</h1>
    <p class="mt-4 max-w-md text-pretty leading-relaxed text-muted-foreground">Можливо, сторінку переміщено або видалено. Скористайтеся навігацією нижче, щоб продовжити знайомство з містом.</p>

    <a href="/" class="mt-8 inline-flex items-center gap-2 rounded-full bg-primary px-6 py-3.5 text-sm font-semibold text-primary-foreground transition-transform hover:scale-[1.02]">
        <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 12H5M12 19l-7-7 7-7"/></svg>
        На головну
    </a>

    @php
        $navLinks = App\Services\ContentService::navLinks();
    @endphp
    <div class="mt-10 flex flex-wrap justify-center gap-2">
        @foreach($navLinks as $link)
            <a href="{{ $link['href'] }}" class="rounded-full border border-border bg-card px-4 py-2 text-sm font-medium text-muted-foreground transition-colors hover:text-foreground">{{ $link['label'] }}</a>
        @endforeach
    </div>
</section>
@endsection
