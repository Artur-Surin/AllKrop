@extends('layouts.app')

@section('meta')
    <x-meta title="{{ $item->title }} — Новини Кропивницького" 
            description="{{ $item->excerpt }}" 
            type="article" 
            image="{{ asset($item->image) }}" />
@endsection

@section('json-ld')
<x-json-ld :schemas="[
    [
        '@context' => 'https://schema.org',
        '@type' => 'NewsArticle',
        'mainEntityOfPage' => [
            '@type' => 'WebPage',
            '@id' => route('news.show', $item->slug),
        ],
        'headline' => $item->title,
        'description' => $item->excerpt,
        'datePublished' => $item->date ?? $item->created_at?->toIso8601String(),
        'dateModified' => $item->updated_at?->toIso8601String() ?? ($item->date ?? $item->created_at?->toIso8601String()),
        'author' => [
            '@type' => 'Organization',
            'name' => 'Кропивницький — міський портал',
            'url' => config('app.url'),
        ],
        'image' => $item->image ? asset($item->image) : asset('/images/hero-city.png'),
        'publisher' => [
            '@type' => 'Organization',
            'name' => 'Кропивницький — міський портал',
            'logo' => [
                '@type' => 'ImageObject',
                'url' => asset('/images/hero-city.png'),
            ],
        ],
    ],
]" />
@endsection

@section('pageTitle', $item->title . ' — Кропивницький')
@section('pageDescription', $item->excerpt)

@section('content')
<article class="mx-auto max-w-3xl px-4 py-8 sm:px-6 sm:py-12">
    <x-breadcrumb :items="[['label' => 'Головна', 'href' => '/'], ['label' => 'Новини', 'href' => route('news.index')], ['label' => $item->title]]" />

    <!-- Article Header -->
    <header class="mt-6">
        <div class="flex flex-wrap items-center gap-2">
            <a href="{{ route('news.index', ['tag' => $item->tag]) }}" 
               class="inline-block rounded-full bg-primary/10 px-3.5 py-1 text-xs font-semibold text-primary border border-primary/20 hover:bg-primary/20 transition-colors">
                {{ $item->tag }}
            </a>
            @if(!empty($item->source))
                <span class="inline-block rounded-full bg-secondary px-3.5 py-1 text-xs font-medium text-muted-foreground border border-border">
                    Джерело: {{ $item->source }}
                </span>
            @endif
        </div>

        <h1 class="mt-4 text-balance font-serif text-2xl sm:text-3xl lg:text-4xl font-bold leading-tight tracking-tight text-foreground">
            {{ $item->title }}
        </h1>

        <div class="mt-4 flex items-center justify-between border-b border-border/80 pb-5 text-sm text-muted-foreground">
            <div class="flex items-center gap-4">
                <span>{{ $item->date }}</span>
                @if($item->read_time)
                    <span class="flex items-center gap-1.5 font-medium">
                        <svg class="h-4 w-4 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><path d="M12 6v6l4 2"/></svg>
                        {{ $item->read_time }}
                    </span>
                @endif
            </div>

            <!-- Share Component -->
            <div x-data="{ copied: false }" class="flex items-center gap-2">
                <span class="hidden text-xs font-medium text-muted-foreground sm:inline">Поділитися:</span>
                <a href="https://t.me/share/url?url={{ urlencode(url()->current()) }}&text={{ urlencode($item->title) }}" 
                   target="_blank" 
                   rel="noopener noreferrer"
                   title="Поділитися в Telegram"
                   class="flex h-8 w-8 items-center justify-center rounded-full bg-secondary text-muted-foreground hover:bg-primary/10 hover:text-primary transition-colors">
                    <svg class="h-4 w-4 fill-current" viewBox="0 0 24 24"><path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm4.64 6.8c-.15 1.58-.8 5.42-1.13 7.19-.14.75-.42 1-.68 1.03-.58.05-1.02-.38-1.58-.75-.88-.58-1.38-.94-2.23-1.5-.99-.65-.35-1.01.22-1.59.15-.15 2.71-2.48 2.76-2.69.01-.03.01-.14-.07-.2-.08-.06-.19-.04-.27-.02-.12.02-1.96 1.25-5.54 3.69-.52.36-1 .53-1.42.52-.47-.01-1.37-.26-2.03-.48-.82-.27-1.47-.42-1.42-.88.03-.24.38-.49 1.05-.75 4.12-1.79 6.87-2.97 8.24-3.54 3.92-1.63 4.73-1.92 5.26-1.93.12 0 .37.03.54.17.14.12.18.28.2.45-.02.07-.02.16-.04.28z"/></svg>
                </a>
                <a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(url()->current()) }}" 
                   target="_blank" 
                   rel="noopener noreferrer"
                   title="Поділитися у Facebook"
                   class="flex h-8 w-8 items-center justify-center rounded-full bg-secondary text-muted-foreground hover:bg-primary/10 hover:text-primary transition-colors">
                    <svg class="h-4 w-4 fill-current" viewBox="0 0 24 24"><path d="M22 12c0-5.52-4.48-10-10-10S2 6.48 2 12c0 4.84 3.44 8.87 8 9.8V15H7.5v-3H10V9.5C10 7.01 11.49 5.65 13.75 5.65c1.08 0 2.2.2 2.2.2v2.42h-1.24c-1.23 0-1.61.76-1.61 1.54V12h2.72l-.43 3h-2.29v6.8c4.56-.93 8-4.96 8-9.8z"/></svg>
                </a>
                <button @click="navigator.clipboard.writeText(window.location.href); copied = true; setTimeout(() => copied = false, 2500)"
                        type="button"
                        title="Скопіювати посилання"
                        class="relative flex h-8 w-8 items-center justify-center rounded-full bg-secondary text-muted-foreground hover:bg-primary/10 hover:text-primary transition-colors">
                    <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z"/></svg>
                    <span x-show="copied" 
                          x-transition
                          class="absolute -top-8 left-1/2 -translate-x-1/2 rounded bg-foreground px-2 py-1 text-[10px] font-medium text-background shadow">
                        Скопійовано!
                    </span>
                </button>
            </div>
        </div>
    </header>

    <!-- Main Image (Fixed Compact Centered Size max-width 480px) -->
    @if($item->image)
        <div class="my-6 flex justify-center">
            <div class="overflow-hidden rounded-2xl border border-border/80 shadow-md w-full max-w-md" style="max-width: 480px;">
                <img src="{{ asset($item->image) }}" alt="{{ $item->title }}" class="aspect-[16/9] w-full object-cover rounded-2xl" loading="lazy" decoding="async">
            </div>
        </div>
    @endif

    <!-- Article Body with Rich Typography -->
    <div class="mt-6 space-y-5 text-base sm:text-lg leading-relaxed text-foreground/90 font-sans">
        @if(is_array($item->body))
            @foreach($item->body as $paragraph)
                @php
                    $trimmed = trim($paragraph);
                    $lower = mb_strtolower($trimmed);
                    $isHeading = (mb_strlen($trimmed) < 85 && !str_ends_with($trimmed, '.') && !str_ends_with($trimmed, '!') && !str_ends_with($trimmed, '?') && !str_starts_with($trimmed, 'перший') && !str_starts_with($trimmed, 'другий'));
                    $isQuote = (str_starts_with($trimmed, '«') || str_starts_with($trimmed, '"') || str_starts_with($trimmed, '“'));
                    $isListItem = (str_starts_with($trimmed, 'перший') || str_starts_with($trimmed, 'другий') || str_starts_with($trimmed, '-') || str_starts_with($trimmed, '•'));
                @endphp

                @if($isHeading)
                    <h2 class="mt-8 mb-3 font-serif text-xl sm:text-2xl font-bold tracking-tight text-foreground border-l-4 border-primary pl-3.5 py-0.5">
                        {{ $trimmed }}
                    </h2>
                @elseif($isQuote)
                    <blockquote class="my-6 rounded-2xl bg-secondary/60 p-5 border-l-4 border-primary text-foreground/90 font-serif italic text-base sm:text-lg leading-relaxed shadow-sm">
                        {{ $trimmed }}
                    </blockquote>
                @elseif($isListItem)
                    <div class="my-2.5 flex items-start gap-3 pl-2 sm:pl-4">
                        <span class="mt-2.5 h-2 w-2 shrink-0 rounded-full bg-primary"></span>
                        <p class="text-base sm:text-lg text-foreground/90 leading-relaxed font-sans">
                            {{ $trimmed }}
                        </p>
                    </div>
                @else
                    <p class="text-base sm:text-lg leading-relaxed sm:leading-8 text-foreground/90 font-sans text-pretty">
                        {{ $trimmed }}
                    </p>
                @endif
            @endforeach
        @elseif(is_string($item->body))
            <div class="prose prose-lg dark:prose-invert max-w-none">
                {!! $item->body !!}
            </div>
        @endif
    </div>

    <!-- Community Callout Banner -->
    <div class="mt-12 rounded-2xl border border-primary/20 bg-primary/5 p-6 flex flex-col sm:flex-row items-center justify-between gap-4">
        <div>
            <h4 class="font-serif text-lg font-bold text-foreground">Слідкуйте за новинами Кропивницького</h4>
            <p class="text-sm text-muted-foreground mt-1">Приєднуйтесь до нашої спільноти у Viber та Telegram</p>
        </div>
        <div class="flex items-center gap-3 shrink-0">
            <a href="https://t.me" target="_blank" rel="noopener noreferrer" class="rounded-full bg-primary px-4 py-2 text-xs font-semibold text-primary-foreground transition-all hover:bg-primary/90">
                Telegram
            </a>
        </div>
    </div>
</article>

<!-- Related Articles Section -->
@if(count($related) > 0)
<section class="border-t border-border bg-secondary/30">
    <div class="mx-auto max-w-6xl px-4 py-12 sm:px-6">
        <div class="flex items-center justify-between">
            <h2 class="font-serif text-2xl font-bold tracking-tight text-foreground">Схожі новини</h2>
            <a href="{{ route('news.index', ['tag' => $item->tag]) }}" class="text-xs font-semibold text-primary hover:underline">
                Усі новини тегу "{{ $item->tag }}" →
            </a>
        </div>
        <div class="mt-6 grid gap-6 sm:grid-cols-2 lg:grid-cols-3">
            @foreach($related as $relatedItem)
                <a href="{{ route('news.show', $relatedItem->slug) }}" class="group flex flex-col overflow-hidden rounded-2xl border border-border bg-card p-4 transition-all duration-300 hover:border-primary/40 hover:shadow-md">
                    <div class="aspect-[16/10] overflow-hidden rounded-xl bg-secondary">
                        <img src="{{ asset($relatedItem->image) }}" alt="{{ $relatedItem->title }}" class="h-full w-full object-cover transition-transform duration-500 group-hover:scale-105" loading="lazy" decoding="async">
                    </div>
                    <div class="mt-4 flex flex-1 flex-col justify-between">
                        <div>
                            <span class="text-xs font-semibold text-primary">{{ $relatedItem->tag }}</span>
                            <h3 class="mt-1 text-pretty font-serif text-base font-bold leading-snug text-foreground group-hover:text-primary transition-colors">
                                {{ $relatedItem->title }}
                            </h3>
                        </div>
                        <span class="mt-4 text-xs text-muted-foreground">{{ $relatedItem->date }}</span>
                    </div>
                </a>
            @endforeach
        </div>
    </div>
</section>
@endif
@endsection
