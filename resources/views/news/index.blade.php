@extends('layouts.app')

@section('meta')
    <x-meta title="{{ $currentTag ? $currentTag . ' — Новини Кропивницького' : 'Свіжі новини міста Кропивницький' }}" 
            description="Головні події, оновлення інфраструктури, культура та життя громади Кропивницького. Актуальні новини міста." 
            image="/images/hero-city.png" />
@endsection

@section('pageTitle', ($currentTag ? $currentTag . ' — ' : '') . 'Новини — Кропивницький')
@section('pageDescription', 'Свіжі новини міста Кропивницький: місто, транспорт, культура, спорт та життя громади.')

@section('content')
<!-- Hero Header Section -->
<section class="border-b border-border bg-gradient-to-b from-secondary/60 to-background">
    <div class="mx-auto max-w-6xl px-4 py-10 sm:px-6 sm:py-14">
        <x-breadcrumb :items="[['label' => 'Головна', 'href' => '/'], ['label' => 'Новини']]" />
        
        <div class="mt-6 flex flex-col gap-6 md:flex-row md:items-end md:justify-between">
            <div>
                <span class="inline-flex items-center gap-1.5 rounded-full bg-primary/10 px-3 py-1 text-xs font-semibold text-primary">
                    <span class="h-2 w-2 rounded-full bg-primary animate-pulse"></span>
                    Міський інформаційний потік
                </span>
                <h1 class="mt-3 text-balance font-serif text-3xl font-bold tracking-tight text-foreground sm:text-4xl lg:text-5xl">
                    Що відбувається у Кропивницькому
                </h1>
                <p class="mt-3 max-w-2xl text-pretty text-base leading-relaxed text-muted-foreground sm:text-lg">
                    Оперативні події, транспортні оновлення, комунальні сповіщення та культура — усе важливе для містян.
                </p>
            </div>

            <!-- Search Bar -->
            <form action="{{ route('news.index') }}" method="GET" class="relative w-full md:w-80 shrink-0">
                @if($currentTag)
                    <input type="hidden" name="tag" value="{{ $currentTag }}">
                @endif
                <div class="relative flex items-center">
                    <input type="text" 
                           name="q" 
                           value="{{ $searchQuery }}" 
                           placeholder="Пошук новин..." 
                           class="w-full rounded-2xl border border-border bg-card py-3 pl-11 pr-10 text-sm placeholder:text-muted-foreground focus:border-primary focus:outline-none focus:ring-2 focus:ring-primary/20 transition-all shadow-sm">
                    <svg class="absolute left-3.5 h-4 w-4 text-muted-foreground" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                    </svg>
                    @if($searchQuery)
                        <a href="{{ route('news.index', array_filter(['tag' => $currentTag])) }}" class="absolute right-3 text-muted-foreground hover:text-foreground">
                            <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                        </a>
                    @endif
                </div>
            </form>
        </div>

        <!-- Tag Navigation Pills -->
        <div class="mt-8 flex flex-wrap items-center gap-2 border-t border-border/60 pt-6">
            <a href="{{ route('news.index', array_filter(['q' => $searchQuery])) }}" 
               class="inline-flex items-center rounded-full px-4 py-2 text-xs font-semibold transition-all shadow-sm {{ !$currentTag ? 'bg-primary text-primary-foreground ring-2 ring-primary/30' : 'bg-card border border-border text-muted-foreground hover:bg-secondary hover:text-foreground' }}">
                Всі новини
            </a>
            @foreach($tags as $tag)
                <a href="{{ route('news.index', array_filter(['tag' => $tag, 'q' => $searchQuery])) }}" 
                   class="inline-flex items-center rounded-full px-4 py-2 text-xs font-semibold transition-all shadow-sm {{ $currentTag === $tag ? 'bg-primary text-primary-foreground ring-2 ring-primary/30' : 'bg-card border border-border text-muted-foreground hover:bg-secondary hover:text-foreground' }}">
                    {{ $tag }}
                </a>
            @endforeach
        </div>
    </div>
</section>

<!-- Active Filter / Search Indicator -->
@if($currentTag || $searchQuery)
    <div class="mx-auto max-w-6xl px-4 pt-6 sm:px-6">
        <div class="flex flex-wrap items-center justify-between gap-3 rounded-2xl bg-secondary/50 p-4 border border-border/80">
            <div class="flex items-center gap-2 text-sm text-foreground">
                <span class="font-medium text-muted-foreground">Фільтр:</span>
                @if($currentTag)
                    <span class="inline-flex items-center gap-1 rounded-lg bg-primary/10 px-2.5 py-1 text-xs font-medium text-primary border border-primary/20">
                        Тег: {{ $currentTag }}
                    </span>
                @endif
                @if($searchQuery)
                    <span class="inline-flex items-center gap-1 rounded-lg bg-primary/10 px-2.5 py-1 text-xs font-medium text-primary border border-primary/20">
                        Пошук: "{{ $searchQuery }}"
                    </span>
                @endif
            </div>
            <a href="{{ route('news.index') }}" class="text-xs font-medium text-primary hover:underline flex items-center gap-1">
                <svg class="h-3.5 w-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                Скинути фільтри
            </a>
        </div>
    </div>
@endif

<!-- Main Content Area -->
<div class="mx-auto max-w-6xl px-4 py-10 sm:px-6 sm:py-14">
    @if($news->count() > 0)
        {{-- Featured Article (only on first page without active search) --}}
        @if($news->onFirstPage() && !$currentTag && !$searchQuery)
            <a href="{{ route('news.show', $news[0]->slug) }}" class="group grid overflow-hidden rounded-3xl border border-border bg-card shadow-sm transition-all duration-300 hover:shadow-md hover:border-primary/40 lg:grid-cols-2 mb-10">
                <div class="relative aspect-[16/10] overflow-hidden lg:aspect-auto">
                    <img src="{{ asset($news[0]->image) }}" alt="{{ $news[0]->title }}" class="h-full w-full object-cover transition-transform duration-700 group-hover:scale-105" loading="lazy" decoding="async">
                    <span class="absolute top-4 left-4 rounded-full bg-background/90 px-3 py-1 text-xs font-semibold text-foreground backdrop-blur border border-border/50 shadow-sm">
                        Головна новина
                    </span>
                </div>
                <div class="flex flex-col justify-between p-6 sm:p-10">
                    <div>
                        <div class="flex items-center gap-2">
                            <span class="w-fit rounded-full bg-primary/10 px-3 py-1 text-xs font-semibold text-primary border border-primary/20">
                                {{ $news[0]->tag }}
                            </span>
                        </div>
                        <h2 class="mt-4 text-balance font-serif text-2xl font-bold leading-snug sm:text-3xl text-foreground group-hover:text-primary transition-colors">
                            {{ $news[0]->title }}
                        </h2>
                        <p class="mt-3 text-pretty leading-relaxed text-muted-foreground line-clamp-3">
                            {{ $news[0]->excerpt }}
                        </p>
                    </div>
                    <div class="mt-6 flex items-center justify-between border-t border-border/60 pt-4 text-xs text-muted-foreground">
                        <span>{{ $news[0]->date }}</span>
                        @if($news[0]->read_time)
                            <span class="flex items-center gap-1.5 font-medium">
                                <svg class="h-3.5 w-3.5 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><path d="M12 6v6l4 2"/></svg>
                                {{ $news[0]->read_time }}
                            </span>
                        @endif
                    </div>
                </div>
            </a>
        @endif

        {{-- Grid of News Cards --}}
        @php
            $gridItems = ($news->onFirstPage() && !$currentTag && !$searchQuery) ? $news->slice(1) : $news;
        @endphp

        <div class="grid gap-6 md:grid-cols-2 lg:grid-cols-3">
            @foreach($gridItems as $item)
                <a href="{{ route('news.show', $item->slug) }}" class="group flex flex-col overflow-hidden rounded-2xl border border-border bg-card shadow-sm transition-all duration-300 hover:-translate-y-1 hover:shadow-md hover:border-primary/40">
                    <div class="relative aspect-[16/10] overflow-hidden bg-secondary">
                        <img src="{{ asset($item->image) }}" alt="{{ $item->title }}" class="h-full w-full object-cover transition-transform duration-500 group-hover:scale-105" loading="lazy" decoding="async">
                        <span class="absolute left-3 top-3 rounded-full bg-background/90 px-3 py-1 text-xs font-semibold text-foreground backdrop-blur border border-border/50 shadow-sm">
                            {{ $item->tag }}
                        </span>
                    </div>
                    <div class="flex flex-1 flex-col justify-between p-5 sm:p-6">
                        <div>
                            <h3 class="text-pretty font-serif text-lg font-bold leading-snug text-foreground group-hover:text-primary transition-colors">
                                {{ $item->title }}
                            </h3>
                            <p class="mt-2.5 text-sm leading-relaxed text-muted-foreground line-clamp-3">
                                {{ $item->excerpt }}
                            </p>
                        </div>
                        <div class="mt-5 flex items-center justify-between border-t border-border/60 pt-4 text-xs text-muted-foreground">
                            <span>{{ $item->date }}</span>
                            @if($item->read_time)
                                <span class="flex items-center gap-1 font-medium">
                                    <svg class="h-3.5 w-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><path d="M12 6v6l4 2"/></svg>
                                    {{ $item->read_time }}
                                </span>
                            @endif
                        </div>
                    </div>
                </a>
            @endforeach
        </div>

        <!-- Community Telegram Banner (Monetization & Retention) -->
        <div class="mt-14 overflow-hidden rounded-3xl border border-primary/20 bg-gradient-to-r from-primary/10 via-primary/5 to-transparent p-6 sm:p-8">
            <div class="flex flex-col items-start gap-6 md:flex-row md:items-center md:justify-between">
                <div class="max-w-xl">
                    <span class="rounded-full bg-primary/15 px-3 py-1 text-xs font-semibold text-primary">
                        Будьте в курсі першими
                    </span>
                    <h3 class="mt-2 font-serif text-2xl font-bold text-foreground">
                        Отримуйте оперативні сповіщення у Telegram
                    </h3>
                    <p class="mt-2 text-sm text-muted-foreground leading-relaxed">
                        Термінові новини міста, перекриття доріг, зміни графіків транспорту та події Кропивницького у вашому смартфоні.
                    </p>
                </div>
                <a href="https://t.me" target="_blank" rel="noopener noreferrer" class="inline-flex shrink-0 items-center gap-2 rounded-full bg-primary px-6 py-3 text-sm font-semibold text-primary-foreground shadow-md transition-all hover:bg-primary/90 hover:shadow-lg">
                    <svg class="h-4 w-4 fill-current" viewBox="0 0 24 24"><path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm4.64 6.8c-.15 1.58-.8 5.42-1.13 7.19-.14.75-.42 1-.68 1.03-.58.05-1.02-.38-1.58-.75-.88-.58-1.38-.94-2.23-1.5-.99-.65-.35-1.01.22-1.59.15-.15 2.71-2.48 2.76-2.69.01-.03.01-.14-.07-.2-.08-.06-.19-.04-.27-.02-.12.02-1.96 1.25-5.54 3.69-.52.36-1 .53-1.42.52-.47-.01-1.37-.26-2.03-.48-.82-.27-1.47-.42-1.42-.88.03-.24.38-.49 1.05-.75 4.12-1.79 6.87-2.97 8.24-3.54 3.92-1.63 4.73-1.92 5.26-1.93.12 0 .37.03.54.17.14.12.18.28.2.45-.02.07-.02.16-.04.28z"/></svg>
                    Підписатися на Telegram
                </a>
            </div>
        </div>

        <!-- Custom Pagination -->
        <div class="mt-12 flex flex-col items-center gap-4 sm:flex-row sm:justify-between border-t border-border pt-6">
            <a href="{{ $news->previousPageUrl() }}" 
               class="inline-flex items-center gap-2 rounded-full border border-border bg-card px-5 py-2.5 text-sm font-semibold text-foreground transition-all hover:bg-secondary {{ $news->onFirstPage() ? 'pointer-events-none opacity-40' : '' }}">
                <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
                Попередня
            </a>
            <span class="text-sm text-muted-foreground">
                Показано <span class="font-semibold text-foreground">{{ $news->firstItem() ?? 0 }}–{{ $news->lastItem() ?? 0 }}</span> з <span class="font-semibold text-foreground">{{ $news->total() }}</span> новин
            </span>
            <a href="{{ $news->nextPageUrl() }}" 
               class="inline-flex items-center gap-2 rounded-full border border-border bg-card px-5 py-2.5 text-sm font-semibold text-foreground transition-all hover:bg-secondary {{ $news->hasMorePages() ? '' : 'pointer-events-none opacity-40' }}">
                Наступна
                <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
            </a>
        </div>
    @else
        <!-- Empty State -->
        <div class="my-16 rounded-3xl border border-dashed border-border p-12 text-center">
            <div class="mx-auto flex h-16 w-16 items-center justify-center rounded-full bg-secondary text-muted-foreground">
                <svg class="h-8 w-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"/></svg>
            </div>
            <h3 class="mt-4 font-serif text-xl font-bold text-foreground">Новин за вашим запитом не знайдено</h3>
            <p class="mt-2 text-sm text-muted-foreground">Спробуйте змінити пошуковий запит або обрати іншу категорію.</p>
            <a href="{{ route('news.index') }}" class="mt-6 inline-flex items-center gap-2 rounded-full bg-primary px-5 py-2.5 text-sm font-semibold text-primary-foreground shadow-sm transition-all hover:bg-primary/90">
                Показати всі новини
            </a>
        </div>
    @endif
</div>
@endsection
