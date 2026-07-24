@extends('layouts.app')

@section('meta')
    <x-meta title="Новини — Кропивницький" description="Свіжі новини міста Кропивницький" />
@endsection

@section('pageTitle', 'Новини — Кропивницький')
@section('pageDescription', 'Свіжі новини міста Кропивницький: місто, транспорт, культура, спорт та життя громади.')

@section('content')
<section class="border-b border-border bg-secondary/40">
    <div class="mx-auto max-w-6xl px-4 py-12 sm:px-6 sm:py-16">
        <nav aria-label="Хлібні крихти" class="flex items-center gap-1.5 text-sm text-muted-foreground">
            <span class="flex items-center gap-1.5">
                <a href="/" class="transition-colors hover:text-foreground">Головна</a>
            </span>
            <span class="flex items-center gap-1.5">
                <svg class="h-3.5 w-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                <span class="text-foreground">Новини</span>
            </span>
        </nav>
        <p class="mt-6 text-sm font-medium text-primary">Новини міста</p>
        <h1 class="mt-2 text-balance font-serif text-4xl font-bold tracking-tight sm:text-5xl">Що відбувається у Кропивницькому</h1>
        <p class="mt-4 max-w-2xl text-pretty text-lg leading-relaxed text-muted-foreground">Головні події, оновлення інфраструктури, культура та життя громади — усе найважливіше в одному місці.</p>
    </div>
</section>

@php
    $news = App\Services\ContentService::news();
    $lead = $news[0];
    $rest = array_slice($news, 1);
@endphp

<div class="mx-auto max-w-6xl px-4 py-14 sm:px-6 sm:py-16">
    <a href="{{ route('news.show', $lead['slug']) }}" class="group grid overflow-hidden rounded-3xl border border-border bg-card transition-colors hover:border-primary/40 lg:grid-cols-2">
        <div class="relative aspect-[16/10] overflow-hidden lg:aspect-auto">
            <img src="{{ $lead['image'] }}" alt="{{ $lead['title'] }}" class="h-full w-full object-cover transition-transform duration-500 group-hover:scale-105" loading="lazy" decoding="async">
        </div>
        <div class="flex flex-col justify-center p-6 sm:p-10">
            <div class="flex items-center gap-2">
                <span class="w-fit rounded-full bg-secondary px-3 py-1 text-xs font-medium text-secondary-foreground">{{ $lead['tag'] }}</span>
                @if(!empty($lead['source']))
                    <span class="w-fit rounded-full bg-blue-100 px-3 py-1 text-xs font-medium text-blue-700 dark:bg-blue-900/30 dark:text-blue-300">{{ $lead['source'] }}</span>
                @endif
            </div>
            <h2 class="mt-4 text-balance font-serif text-2xl font-bold leading-snug sm:text-3xl">{{ $lead['title'] }}</h2>
            <p class="mt-3 text-pretty leading-relaxed text-muted-foreground">{{ $lead['excerpt'] }}</p>
            <div class="mt-6 flex items-center gap-4 text-xs text-muted-foreground">
                <span>{{ $lead['date'] }}</span>
                <span class="flex items-center gap-1">
                    <svg class="h-3.5 w-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><path d="M12 6v6l4 2"/></svg>
                    {{ $lead['read'] }} читання
                </span>
            </div>
        </div>
    </a>

    <div class="mt-8 grid gap-5 md:grid-cols-2 lg:grid-cols-3">
        @foreach($rest as $item)
            <a href="{{ route('news.show', $item['slug']) }}" class="group flex flex-col overflow-hidden rounded-2xl border border-border bg-card transition-colors hover:border-primary/40">
                <div class="relative aspect-[16/10] overflow-hidden">
                    <img src="{{ $item['image'] }}" alt="{{ $item['title'] }}" class="h-full w-full object-cover transition-transform duration-500 group-hover:scale-105" loading="lazy" decoding="async">
                    <span class="absolute left-3 top-3 rounded-full bg-background/90 px-3 py-1 text-xs font-medium backdrop-blur">{{ $item['tag'] }}</span>
                    @if(!empty($item['source']))
                        <span class="absolute right-3 top-3 rounded-full bg-blue-100/90 px-3 py-1 text-xs font-medium text-blue-700 backdrop-blur dark:bg-blue-900/30 dark:text-blue-300">{{ $item['source'] }}</span>
                    @endif
                </div>
                <div class="flex flex-1 flex-col p-6">
                    <h3 class="text-pretty font-serif text-lg font-semibold leading-snug">{{ $item['title'] }}</h3>
                    <p class="mt-3 flex-1 text-sm leading-relaxed text-muted-foreground">{{ $item['excerpt'] }}</p>
                    <div class="mt-5 flex items-center justify-between border-t border-border pt-4 text-xs text-muted-foreground">
                        <span>{{ $item['date'] }}</span>
                        <svg class="h-4 w-4 transition-transform group-hover:-translate-y-0.5 group-hover:translate-x-0.5 group-hover:text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 17L17 7M17 7H7M17 7v10"/></svg>
                    </div>
                </div>
            </a>
        @endforeach
    </div>
</div>
@endsection
