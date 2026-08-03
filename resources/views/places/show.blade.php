@extends('layouts.app')

@php
    $category = $place->category;
    $reviews = $place->reviews()->get();
    $avgRating = $place->average_rating;
    $reviewsCount = $place->reviews_count;
@endphp

@section('meta')
    <x-meta title="{{ $place->name }} — Кропивницький" description="{{ $place->description[0] ?? $place->name }}" image="{{ $place->image }}" />
@endsection

@section('json-ld')
@php
    $schemas = [
        [
            '@context' => 'https://schema.org',
            '@type' => 'LocalBusiness',
            'name' => $place->name,
            'address' => [
                '@type' => 'PostalAddress',
                'streetAddress' => $place->address,
                'addressLocality' => 'Кропивницький',
                'addressCountry' => 'UA',
            ],
            'telephone' => $place->phone,
            'openingHours' => $place->hours,
            'image' => $place->image ? asset($place->image) : null,
        ],
    ];
    if ($reviewsCount > 0) {
        $schemas[0]['aggregateRating'] = [
            '@type' => 'AggregateRating',
            'ratingValue' => $avgRating,
            'reviewCount' => $reviewsCount,
            'bestRating' => 5,
            'worstRating' => 1,
        ];
    }
@endphp
<x-json-ld :schemas="$schemas" />
@endsection

@section('pageTitle', $place->name . ' — Кропивницький')
@section('pageDescription', $place->description[0] ?? $place->name)

@section('content')
<div class="mx-auto max-w-6xl px-4 py-12 sm:px-6 sm:py-16">
    <x-breadcrumb :items="[
        ['label' => 'Головна', 'href' => '/'],
        ['label' => 'Каталог', 'href' => route('places.index')],
        $category ? ['label' => $category->label, 'href' => route('places.category', $category->key)] : null,
        ['label' => $place->name],
    ]" />

    <div class="mt-8 grid gap-10 lg:grid-cols-[1.5fr_1fr]">
        <div>
            @php
                $gallery = array_values(array_filter(array_merge([$place->image_url], $place->gallery_urls)));
                $galleryCount = count($gallery);
            @endphp

            <div
                x-data="{
                    open: false,
                    current: 0,
                    total: {{ $galleryCount }},
                    openAt(i) { this.current = i; this.open = true; document.body.style.overflow = 'hidden'; },
                    close() { this.open = false; document.body.style.overflow = ''; },
                    next() { this.current = (this.current + 1) % this.total; },
                    prev() { this.current = (this.current - 1 + this.total) % this.total; }
                }"
                @keydown.escape.window="close()"
                @keydown.arrow-left.window="if(open) prev()"
                @keydown.arrow-right.window="if(open) next()"
            >
                {{-- Головне фото --}}
                <div
                    class="group relative cursor-zoom-in overflow-hidden rounded-3xl border border-border shadow-sm"
                    @click="openAt(current)"
                >
                    @foreach($gallery as $idx => $img)
                        <img
                            src="{{ $img }}"
                            alt="{{ $place->name }} — фото {{ $idx + 1 }}"
                            x-show="current === {{ $idx }}"
                            @if($idx !== 0) style="display:none" @endif
                            class="aspect-[16/10] w-full object-cover"
                            loading="{{ $idx === 0 ? 'eager' : 'lazy' }}"
                            decoding="async"
                        >
                    @endforeach

                    {{-- Підказка "Збільшити" --}}
                    <div class="pointer-events-none absolute inset-0 flex items-end justify-end p-4">
                        <span class="flex items-center gap-1.5 rounded-full bg-black/50 px-3 py-1.5 text-xs font-semibold text-white opacity-0 backdrop-blur-sm transition-opacity group-hover:opacity-100">
                            <svg class="h-3.5 w-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-4.35-4.35M17 11A6 6 0 1 1 5 11a6 6 0 0 1 12 0z"/></svg>
                            Збільшити
                        </span>
                    </div>

                    @if($galleryCount > 1)
                        {{-- Стрілки на фото --}}
                        <div class="absolute inset-y-0 left-0 right-0 flex items-center justify-between px-3 opacity-0 transition-opacity group-hover:opacity-100" @click.stop>
                            <button type="button" @click.stop="prev()" class="flex h-9 w-9 items-center justify-center rounded-full bg-black/50 text-white backdrop-blur-sm transition-colors hover:bg-black/70">
                                <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
                            </button>
                            <button type="button" @click.stop="next()" class="flex h-9 w-9 items-center justify-center rounded-full bg-black/50 text-white backdrop-blur-sm transition-colors hover:bg-black/70">
                                <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                            </button>
                        </div>
                        {{-- Лічильник --}}
                        <div class="absolute bottom-3 right-3 rounded-full bg-black/50 px-2.5 py-1 text-xs font-semibold text-white backdrop-blur-sm" x-text="`${current + 1} / {{ $galleryCount }}`"></div>
                    @endif
                </div>

                @if($galleryCount > 1)
                    {{-- Стрічка мініатюр --}}
                    <div class="mt-3 flex gap-2 overflow-x-auto pb-1">
                        @foreach($gallery as $idx => $img)
                            <button
                                type="button"
                                @click="current = {{ $idx }}"
                                :class="current === {{ $idx }} ? 'ring-2 ring-primary ring-offset-2 ring-offset-background opacity-100' : 'opacity-50 hover:opacity-90'"
                                class="aspect-square h-16 w-16 shrink-0 overflow-hidden rounded-xl border border-border/60 bg-card transition-all duration-200 focus:outline-none sm:h-[72px] sm:w-[72px]"
                            >
                                <img src="{{ $img }}" alt="{{ $place->name }} мін. {{ $idx + 1 }}" class="h-full w-full object-cover">
                            </button>
                        @endforeach
                    </div>
                @endif

                {{-- Lightbox — телепортується у <body> --}}
                <template x-teleport="body">
                    <div
                        x-show="open"
                        x-transition:enter="transition-opacity duration-200 ease-out"
                        x-transition:enter-start="opacity-0"
                        x-transition:enter-end="opacity-100"
                        x-transition:leave="transition-opacity duration-150 ease-in"
                        x-transition:leave-start="opacity-100"
                        x-transition:leave-end="opacity-0"
                        style="display:none"
                        class="fixed inset-0 z-[9999] flex items-center justify-center bg-black/95 backdrop-blur-sm"
                        @click.self="close()"
                    >
                        {{-- Закрити --}}
                        <button type="button" @click="close()" class="absolute right-4 top-4 z-10 flex h-10 w-10 items-center justify-center rounded-full bg-white/15 text-white transition-colors hover:bg-white/30">
                            <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                        </button>

                        @if($galleryCount > 1)
                            <button type="button" @click="prev()" class="absolute left-4 top-1/2 z-10 flex h-12 w-12 -translate-y-1/2 items-center justify-center rounded-full bg-white/15 text-white transition-colors hover:bg-white/30">
                                <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
                            </button>
                            <button type="button" @click="next()" class="absolute right-4 top-1/2 z-10 flex h-12 w-12 -translate-y-1/2 items-center justify-center rounded-full bg-white/15 text-white transition-colors hover:bg-white/30">
                                <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                            </button>
                        @endif

                        <div class="flex flex-col items-center gap-3 p-4">
                            @foreach($gallery as $idx => $img)
                                <img
                                    src="{{ $img }}"
                                    alt="{{ $place->name }} — фото {{ $idx + 1 }}"
                                    x-show="current === {{ $idx }}"
                                    @if($idx !== 0) style="display:none" @endif
                                    class="max-h-[85vh] max-w-[90vw] rounded-xl object-contain shadow-2xl"
                                >
                            @endforeach

                            @if($galleryCount > 1)
                                <div class="flex gap-2">
                                    @foreach($gallery as $idx => $img)
                                        <button
                                            type="button"
                                            @click="current = {{ $idx }}"
                                            :class="current === {{ $idx }} ? 'bg-white scale-110' : 'bg-white/40 hover:bg-white/70'"
                                            class="h-2 w-2 rounded-full transition-all"
                                        ></button>
                                    @endforeach
                                </div>
                                <p class="text-xs text-white/60" x-text="`${current + 1} з {{ $galleryCount }}`"></p>
                            @endif
                        </div>
                    </div>
                </template>
            </div>
            <p class="mt-6 text-sm font-medium text-primary">{{ $place->category->label ?? '' }}</p>
            <h1 class="mt-2 text-balance font-serif text-3xl font-bold tracking-tight sm:text-4xl">{{ $place->name }}</h1>
            <div class="mt-3 flex items-center gap-4 text-sm text-muted-foreground">
                <span class="flex items-center gap-1 font-medium text-foreground">
                    <svg class="h-4 w-4 fill-accent text-accent" viewBox="0 0 24 24"><path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/></svg>
                    {{ $avgRating > 0 ? $avgRating : $place->rating }}
                    @if($reviewsCount > 0)
                        <span class="text-muted-foreground">({{ $reviewsCount }} відгуків)</span>
                    @endif
                </span>
                <span class="flex items-center gap-1">
                    <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                    {{ $place->area }}
                </span>
            </div>
            <div class="mt-6 space-y-4 text-lg leading-relaxed text-foreground/90">
                @foreach($place->description as $paragraph)
                    <p class="text-pretty">{{ $paragraph }}</p>
                @endforeach
            </div>
        </div>

        <aside class="h-fit rounded-2xl border border-border bg-card p-6">
            <p class="font-serif text-lg font-semibold">Інформація</p>
            <dl class="mt-5 space-y-4">
                <div class="flex items-start gap-3">
                    <svg class="mt-0.5 h-5 w-5 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M20 21v-2a4 4 0 00-4-4H8a4 4 0 00-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
                    <div>
                        <dt class="text-xs text-muted-foreground">Категорія</dt>
                        <dd class="text-sm font-medium">{{ $place->category->label ?? '' }}</dd>
                    </div>
                </div>
                <div class="flex items-start gap-3">
                    <svg class="mt-0.5 h-5 w-5 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                    <div>
                        <dt class="text-xs text-muted-foreground">Адреса</dt>
                        <dd class="text-sm font-medium">{{ $place->address }}</dd>
                    </div>
                </div>
                <div class="flex items-start gap-3">
                    <svg class="mt-0.5 h-5 w-5 shrink-0 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><path d="M12 6v6l4 2"/></svg>
                    <div class="w-full">
                        <dt class="text-xs text-muted-foreground mb-2">Години роботи</dt>
                        <dd class="space-y-1.5 text-sm">
                            @foreach($place->working_schedule as $item)
                                <div class="flex items-center gap-3">
                                    <span class="w-8 shrink-0 {{ $item['is_today'] ? 'font-bold text-foreground' : 'text-muted-foreground font-normal' }}">
                                        {{ $item['day'] }}
                                    </span>
                                    <span class="{{ $item['is_today'] ? 'font-bold text-foreground' : ($item['is_closed'] ? 'text-muted-foreground' : 'text-foreground/90 font-normal') }}">
                                        {{ $item['hours'] }}
                                    </span>
                                </div>
                            @endforeach
                        </dd>
                    </div>
                </div>
                <div class="flex items-start gap-3">
                    <svg class="mt-0.5 h-5 w-5 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M22 16.92v3a2 2 0 01-2.18 2 19.79 19.79 0 01-8.63-3.07 19.5 19.5 0 01-6-6 19.79 19.79 0 01-3.07-8.67A2 2 0 014.11 2h3a2 2 0 012 1.72c.127.96.361 1.903.7 2.81a2 2 0 01-.45 2.11L8.09 9.91a16 16 0 006 6l1.27-1.27a2 2 0 012.11-.45c.907.339 1.85.573 2.81.7A2 2 0 0122 16.92z"/></svg>
                    <div>
                        <dt class="text-xs text-muted-foreground">Телефон</dt>
                        <dd class="text-sm font-medium">{{ $place->phone }}</dd>
                    </div>
                </div>
            </dl>
            <a href="https://www.google.com/maps/dir/?api=1&destination={{ urlencode($place->address . ', Кропивницький') }}" target="_blank" rel="noopener noreferrer" class="mt-6 block w-full rounded-full bg-primary px-6 py-3 text-center text-sm font-semibold text-primary-foreground transition-transform hover:scale-[1.02]">Прокласти маршрут</a>
        </aside>
    </div>

    {{-- Блок послуг компанії --}}
    @if(!empty($place->features) && count($place->features) > 0)
    <section class="mt-12 rounded-3xl border border-border bg-card p-6 sm:p-8 shadow-sm">
        <div class="flex items-center gap-3.5 mb-8">
            <span class="flex h-12 w-12 items-center justify-center rounded-2xl bg-primary/10 text-primary flex-shrink-0 shadow-inner">
                <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                </svg>
            </span>
            <div>
                <p class="text-xs font-semibold uppercase tracking-wider text-primary">Зручності та сервіс</p>
                <h2 class="font-serif text-2xl font-bold tracking-tight text-foreground">Послуги компанії</h2>
            </div>
        </div>

        <div class="grid gap-6 sm:grid-cols-2 lg:grid-cols-3">
            @foreach($place->features as $feature)
                @if(!empty($feature['group']) && !empty($feature['items']))
                <div class="group flex flex-col rounded-2xl border border-border/80 bg-secondary/30 p-5 transition-all duration-300 hover:border-primary/40 hover:bg-secondary/50 hover:shadow-md">
                    <div class="flex items-center gap-2.5 mb-3.5">
                        <span class="flex h-7 w-7 items-center justify-center rounded-lg bg-primary/15 text-primary">
                            @if(str_contains(mb_strtolower($feature['group']), 'кухня'))
                                <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/></svg>
                            @elseif(str_contains(mb_strtolower($feature['group']), 'доставка'))
                                <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16V6a1 1 0 00-1-1H4a1 1 0 00-1 1v10a1 1 0 001 1h1m8-1a1 1 0 01-1 1H9m4-1V8a1 1 0 011-1h2.586a1 1 0 01.707.293l3.414 3.414a1 1 0 01.293.707V16a1 1 0 01-1 1h-1m-6-1a2 2 0 104 0m-4 0a2 2 0 114 0m-6 0a2 2 0 104 0m-4 0a2 2 0 114 0"/></svg>
                            @elseif(str_contains(mb_strtolower($feature['group']), 'зал'))
                                <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5m0 0h4m-4 0V11m0 0h4m-4 0H9"/></svg>
                            @elseif(str_contains(mb_strtolower($feature['group']), 'додатков'))
                                <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z"/></svg>
                            @else
                                <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.828 14.828a4 4 0 01-5.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                            @endif
                        </span>
                        <h3 class="font-serif text-base font-semibold text-foreground tracking-tight">
                            {{ $feature['group'] }}
                        </h3>
                    </div>

                    <div class="flex flex-wrap gap-2 mt-auto pt-1">
                        @foreach($feature['items'] as $item)
                            <span class="inline-flex items-center gap-1.5 rounded-xl border border-border/70 bg-card px-3 py-1.5 text-xs font-medium text-foreground/90 shadow-2xs transition-all hover:border-primary/40 hover:bg-primary/5 hover:text-primary">
                                <span class="h-1.5 w-1.5 rounded-full bg-primary/60"></span>
                                {{ $item }}
                            </span>
                        @endforeach
                    </div>
                </div>
                @endif
            @endforeach
        </div>
    </section>
    @endif

    {{-- Відгуки --}}
    <section class="mt-16 border-t border-border pt-16">
        <div class="flex items-end justify-between gap-4">
            <div>
                <p class="text-sm font-medium text-primary">Відгуки</p>
                <h2 class="mt-2 text-balance font-serif text-3xl font-bold tracking-tight sm:text-4xl">Що кажуть відвідувачі</h2>
            </div>
        </div>

        {{-- Форма відгуку --}}
        <div class="mt-8 rounded-2xl border border-border bg-card p-6 sm:p-8">
            <h3 class="font-serif text-lg font-semibold">Залишити відгук</h3>
            <form id="review-form" class="mt-4 space-y-4">
                <div class="grid gap-4 sm:grid-cols-2">
                    <div>
                        <label for="review-name" class="text-sm font-medium">Ім'я</label>
                        <input type="text" id="review-name" required placeholder="Ваше ім'я" class="mt-1.5 h-12 w-full rounded-xl border border-border bg-background px-4 text-sm outline-none transition-colors focus:border-primary">
                    </div>
                    <div>
                        <label class="text-sm font-medium">Оцінка</label>
                        <div class="mt-1.5 flex gap-1" id="rating-stars">
                            @for($i = 1; $i <= 5; $i++)
                                <button type="button" data-rating="{{ $i }}" class="star-btn h-10 w-10 rounded-lg border border-border text-2xl transition-colors hover:bg-secondary">
                                    ☆
                                </button>
                            @endfor
                            <input type="hidden" name="rating" id="rating-input" value="0">
                        </div>
                    </div>
                </div>
                <div>
                    <label for="review-comment" class="text-sm font-medium">Ваш відгук</label>
                    <textarea id="review-comment" rows="4" required placeholder="Розкажіть про свій досвід..." class="mt-1.5 w-full rounded-xl border border-border bg-background px-4 py-3 text-sm outline-none transition-colors focus:border-primary"></textarea>
                </div>
                <button type="submit" class="inline-flex items-center justify-center gap-2 rounded-full bg-primary px-6 py-3 text-sm font-semibold text-primary-foreground transition-transform hover:scale-[1.02]">
                    Надіслати відгук
                    <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M22 2L11 13M22 2l-7 20-4-9-9-4 20-7z"/></svg>
                </button>
            </form>
            <div id="review-success" class="hidden mt-4 rounded-xl bg-green-500/10 p-4 text-center text-sm text-green-600">
                Дякуємо! Ваш відгук надіслано та з'явиться після модерації.
            </div>
        </div>

        {{-- Список відгуків --}}
        @if($reviews->count() > 0)
            <div class="mt-8 space-y-4">
                @foreach($reviews as $review)
                    <div class="rounded-2xl border border-border bg-card p-5">
                        <div class="flex items-center justify-between">
                            <div class="flex items-center gap-3">
                                <div class="flex h-10 w-10 items-center justify-center rounded-full bg-primary/10 text-primary font-semibold text-sm">
                                    {{ strtoupper(mb_substr($review->name, 0, 1)) }}
                                </div>
                                <div>
                                    <p class="font-medium text-sm">{{ $review->name }}</p>
                                    <p class="text-xs text-muted-foreground">{{ $review->created_at->format('d.m.Y') }}</p>
                                </div>
                            </div>
                            <div class="flex gap-0.5">
                                @for($i = 1; $i <= 5; $i++)
                                    <span class="{{ $i <= $review->rating ? 'text-accent' : 'text-muted-foreground/30' }}">★</span>
                                @endfor
                            </div>
                        </div>
                        <p class="mt-3 text-sm leading-relaxed text-foreground/80">{{ $review->comment }}</p>
                    </div>
                @endforeach
            </div>
        @endif
    </section>

    {{-- Схожі заклади --}}
    @if(isset($relatedPlaces) && $relatedPlaces->count() > 0)
    <section class="mt-16 border-t border-border pt-16">
        <div class="flex items-center justify-between gap-4">
            <div>
                <p class="text-xs font-semibold uppercase tracking-wider text-primary">Рекомендації</p>
                <h2 class="mt-1 font-serif text-2xl font-bold tracking-tight text-foreground sm:text-3xl">Схожі заклади</h2>
            </div>
            @if($category)
                <a href="{{ route('places.category', $category->key) }}" class="inline-flex items-center gap-1.5 text-sm font-semibold text-primary hover:underline">
                    Усі з цієї категорії
                    <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/></svg>
                </a>
            @endif
        </div>

        <div class="mt-8 grid gap-6 md:grid-cols-3">
            @foreach($relatedPlaces as $relPlace)
                <a href="{{ route('places.show', $relPlace->slug) }}" class="group overflow-hidden rounded-2xl border border-border bg-card transition-all duration-300 hover:border-primary/40 hover:shadow-md">
                    <div class="relative aspect-[16/10] overflow-hidden">
                        <img src="{{ $relPlace->image_url }}" alt="{{ $relPlace->name }}" class="h-full w-full object-cover transition-transform duration-500 group-hover:scale-105" loading="lazy" decoding="async">
                        <span class="absolute right-3 top-3 flex items-center gap-1 rounded-full bg-background/90 px-2.5 py-1 text-xs font-semibold backdrop-blur">
                            <svg class="h-3.5 w-3.5 fill-accent text-accent" viewBox="0 0 24 24"><path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/></svg>
                            {{ $relPlace->rating }}
                        </span>
                    </div>
                    <div class="p-5">
                        <p class="text-xs font-medium text-primary">{{ $relPlace->category->label ?? '' }}</p>
                        <h3 class="mt-1.5 font-serif text-base font-semibold text-foreground group-hover:text-primary transition-colors">{{ $relPlace->name }}</h3>
                        <p class="mt-2 flex items-center gap-1.5 text-xs text-muted-foreground">
                            <svg class="h-3.5 w-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                            {{ $relPlace->area }}
                        </p>
                    </div>
                </a>
            @endforeach
        </div>
    </section>
    @endif
</div>
@endsection

@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        let selectedRating = 0;

        function setRating(rating) {
            selectedRating = rating;
            document.getElementById('rating-input').value = rating;
            document.querySelectorAll('.star-btn').forEach(function(btn, i) {
                btn.textContent = i < rating ? '★' : '☆';
                btn.classList.toggle('bg-accent/20', i < rating);
                btn.classList.toggle('text-accent', i < rating);
            });
        }

        document.querySelectorAll('.star-btn').forEach(function(btn) {
            btn.addEventListener('click', function() {
                setRating(parseInt(btn.dataset.rating, 10));
            });
        });

        document.getElementById('review-form').addEventListener('submit', function(e) {
            e.preventDefault();
            if (selectedRating === 0) {
                alert('Будь ласка, оберіть оцінку');
                return;
            }

            var name = document.getElementById('review-name').value;
            var comment = document.getElementById('review-comment').value;

            fetch('{{ route("reviews.store", $place->slug) }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                    'Accept': 'application/json',
                },
                body: JSON.stringify({
                    name: name,
                    rating: selectedRating,
                    comment: comment,
                }),
            }).then(function(response) {
                if (response.ok) {
                    document.getElementById('review-form').classList.add('hidden');
                    document.getElementById('review-success').classList.remove('hidden');
                }
            }).catch(function() {
                alert('Помилка надсилання. Спробуйте ще раз.');
            });
        });
    });
</script>
@endsection
