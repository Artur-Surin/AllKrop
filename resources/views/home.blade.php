@extends('layouts.app')

@section('meta')
    <x-meta title="Кропивницький — міський портал" description="Все про місто Кропивницький: новини, афіша подій, довідник закладів та туристичний гід." image="/images/hero-city.png" />
@endsection

@section('json-ld')
<x-json-ld :schemas="[
    [
        '@context' => 'https://schema.org',
        '@type' => 'WebSite',
        'name' => 'Кропивницький — міський портал',
        'url' => url('/'),
        'potentialAction' => [
            '@type' => 'SearchAction',
            'target' => url('/search') . '?q={search_term_string}',
            'query-input' => 'required name=search_term_string',
        ],
    ],
    [
        '@context' => 'https://schema.org',
        '@type' => 'Organization',
        'name' => 'Кропивницький — міський портал',
        'url' => url('/'),
        'logo' => url('/images/hero-city.png'),
        'address' => [
            '@type' => 'PostalAddress',
            'streetAddress' => 'вул. Велика Перспективна, 41',
            'addressLocality' => 'Кропивницький',
            'addressCountry' => 'UA',
        ],
    ],
]" />
@endsection

@section('pageTitle', 'Кропивницький — міський портал')
@section('pageDescription', 'Все про місто Кропивницький: новини, афіша подій, довідник закладів та туристичний гід.')

@section('content')
        {{-- Hero --}}
        <section id="top" class="relative overflow-hidden">
            <div class="mx-auto max-w-6xl px-4 pb-16 pt-14 sm:px-6 sm:pb-20 sm:pt-20">
                <div class="grid items-center gap-10 lg:grid-cols-[1.05fr_0.95fr]">
                    <div>
                        <span class="inline-flex items-center gap-2 rounded-full border border-border bg-secondary/60 px-3.5 py-1.5 text-xs font-medium text-muted-foreground">
                            <svg class="h-3.5 w-3.5 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                            Кіровоградська область · Центральна Україна
                        </span>

                        <h1 class="mt-6 text-balance font-serif text-5xl font-bold leading-[1.02] tracking-tight sm:text-6xl lg:text-7xl">
                            Кропивницький — місто, яке варто відкрити
                        </h1>

                        <p class="mt-5 max-w-xl text-pretty text-lg leading-relaxed text-muted-foreground">
                            Єдиний портал міста: свіжі новини, афіша подій, довідник улюблених
                            закладів і туристичний гід — усе в одному місці.
                        </p>

                        <div class="mt-8 flex flex-col gap-3 sm:flex-row">
                            <a href="/events" class="inline-flex items-center justify-center gap-2 rounded-full bg-primary px-6 py-3.5 text-sm font-semibold text-primary-foreground transition-transform hover:scale-[1.02]">
                                Дивитись афішу
                                <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg>
                            </a>
                            <a href="/places" class="inline-flex items-center justify-center gap-2 rounded-full border border-border bg-card px-6 py-3.5 text-sm font-semibold text-foreground transition-colors hover:bg-secondary">
                                <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><circle cx="11" cy="11" r="8"/><path d="M21 21l-4.35-4.35"/></svg>
                                Знайти заклад
                            </a>
                        </div>

                        <dl class="mt-12 grid grid-cols-2 gap-x-6 gap-y-6 sm:grid-cols-4">
                            @php
                                $stats = App\Services\ContentService::stats();
                            @endphp
                            @foreach($stats as $s)
                                <div>
                                    <dt class="sr-only">{{ $s['label'] }}</dt>
                                    <dd class="font-serif text-3xl font-bold text-foreground">{{ $s['value'] }}</dd>
                                    <p class="mt-1 text-xs leading-snug text-muted-foreground">{{ $s['label'] }}</p>
                                </div>
                            @endforeach
                        </dl>
                    </div>

                    <div class="relative">
                        <div class="relative aspect-[4/5] overflow-hidden rounded-3xl border border-border elevated">
                            <img src="/images/hero-city.png" alt="Панорама міста Кропивницький у золоту годину" class="h-full w-full object-cover" fetchpriority="high" loading="eager" decoding="async" width="800" height="1000">
                            <div class="absolute inset-x-4 bottom-4 rounded-2xl border border-white/15 bg-black/35 p-4 backdrop-blur-md">
                                <p class="text-sm font-medium text-white">Історичний центр</p>
                                <p class="text-xs text-white/70">Прогулянкові маршрути та архітектура ХІХ століття</p>
                            </div>
                        </div>
                        <div class="absolute -right-3 -top-3 hidden h-24 w-24 rounded-2xl bg-accent sm:block" aria-hidden="true"></div>
                    </div>
                </div>
            </div>
        </section>

        {{-- Новини --}}
        <section id="news" class="border-t border-border bg-background">
            <div class="mx-auto max-w-6xl px-4 py-16 sm:px-6 sm:py-24">
                <div class="flex items-end justify-between gap-4">
                    <div>
                        <p class="text-sm font-medium text-primary">Новини міста</p>
                        <h2 class="mt-2 text-balance font-serif text-3xl font-bold tracking-tight sm:text-4xl">Що відбувається у Кропивницькому</h2>
                    </div>
                    <a href="/news" class="hidden shrink-0 items-center gap-1 text-sm font-medium text-muted-foreground transition-colors hover:text-foreground sm:inline-flex">
                        Усі новини
                        <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 17L17 7M17 7H7M17 7v10"/></svg>
                    </a>
                </div>

                <div class="mt-10 grid gap-5 md:grid-cols-3">
                    @php
                        $news = App\Services\ContentService::news();
                    @endphp
                    @foreach(array_slice($news, 0, 3) as $item)
                        <a href="/news/{{ $item['slug'] }}" class="group flex flex-col rounded-2xl border border-border bg-card p-6 transition-colors hover:border-primary/40">
                            <div class="flex items-center justify-between">
                                <span class="rounded-full bg-secondary px-3 py-1 text-xs font-medium text-secondary-foreground">{{ $item['tag'] }}</span>
                                <svg class="h-5 w-5 text-muted-foreground transition-transform group-hover:-translate-y-0.5 group-hover:translate-x-0.5 group-hover:text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 17L17 7M17 7H7M17 7v10"/></svg>
                            </div>
                            <h3 class="mt-4 text-pretty font-serif text-xl font-semibold leading-snug">{{ $item['title'] }}</h3>
                            <p class="mt-3 flex-1 text-sm leading-relaxed text-muted-foreground">{{ $item['excerpt'] }}</p>
                            <div class="mt-5 flex items-center gap-4 border-t border-border pt-4 text-xs text-muted-foreground">
                                <span>{{ $item['date'] }}</span>
                                <span class="flex items-center gap-1">
                                    <svg class="h-3.5 w-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><path d="M12 6v6l4 2"/></svg>
                                    {{ $item['read'] }} читання
                                </span>
                            </div>
                        </a>
                    @endforeach
                </div>
            </div>
        </section>

        {{-- Афіша --}}
        <section id="events" class="border-t border-border bg-secondary/40">
            <div class="mx-auto max-w-6xl px-4 py-16 sm:px-6 sm:py-24">
                <div class="flex items-end justify-between gap-4">
                    <div class="max-w-2xl">
                        <p class="text-sm font-medium text-primary">Афіша</p>
                        <h2 class="mt-2 text-balance font-serif text-3xl font-bold tracking-tight sm:text-4xl">Найближчі події та розваги</h2>
                        <p class="mt-3 text-pretty leading-relaxed text-muted-foreground">Концерти, вистави, ярмарки та фестивалі — обирайте, куди піти цими вихідними.</p>
                    </div>
                    <a href="/events" class="hidden shrink-0 items-center gap-1 text-sm font-medium text-muted-foreground transition-colors hover:text-foreground sm:inline-flex">
                        Уся афіша
                        <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 17L17 7M17 7H7M17 7v10"/></svg>
                    </a>
                </div>

                <div class="mt-10 grid gap-6 md:grid-cols-3">
                    @php
                        $events = App\Services\ContentService::events();
                    @endphp
                    @foreach(array_slice($events, 0, 3) as $ev)
                        <a href="/events/{{ $ev['slug'] }}" class="group overflow-hidden rounded-2xl border border-border bg-card transition-transform hover:-translate-y-1">
                            <div class="relative aspect-[3/2] overflow-hidden">
                                <img src="{{ $ev['image'] }}" alt="{{ $ev['title'] }}" class="h-full w-full object-cover transition-transform duration-500 group-hover:scale-105" loading="lazy" decoding="async">
                                <div class="absolute left-3 top-3 flex flex-col items-center rounded-xl bg-background/90 px-3 py-1.5 text-center backdrop-blur">
                                    <span class="font-serif text-lg font-bold leading-none">{{ explode(' ', $ev['date'])[0] }}</span>
                                    <span class="text-[10px] font-medium uppercase tracking-wide text-muted-foreground">{{ explode(' ', $ev['date'])[1] }}</span>
                                </div>
                                <span class="absolute right-3 top-3 rounded-full bg-accent px-3 py-1 text-xs font-semibold text-accent-foreground">{{ $ev['category'] }}</span>
                            </div>
                            <div class="p-5">
                                <h3 class="text-pretty font-serif text-lg font-semibold leading-snug">{{ $ev['title'] }}</h3>
                                <ul class="mt-4 space-y-2 text-sm text-muted-foreground">
                                    <li class="flex items-center gap-2">
                                        <svg class="h-4 w-4 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><path d="M12 6v6l4 2"/></svg>
                                        {{ $ev['time'] }}
                                    </li>
                                    <li class="flex items-center gap-2">
                                        <svg class="h-4 w-4 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                                        {{ $ev['place'] }}
                                    </li>
                                    <li class="flex items-center gap-2">
                                        <svg class="h-4 w-4 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M15 5v2m0 4v2m0 4v2M5 5a2 2 0 00-2 2v3a2 2 0 110 4v3a2 2 0 002 2h14a2 2 0 002-2v-3a2 2 0 110-4V7a2 2 0 00-2-2H5z"/></svg>
                                        {{ $ev['price'] }}
                                    </li>
                                </ul>
                            </div>
                        </a>
                    @endforeach
                </div>
            </div>
        </section>

        {{-- Заклади --}}
        <section id="places" class="border-t border-border bg-background">
            <div class="mx-auto max-w-6xl px-4 py-16 sm:px-6 sm:py-24">
                <div class="flex items-end justify-between gap-4">
                    <div class="max-w-2xl">
                        <p class="text-sm font-medium text-primary">Довідник закладів</p>
                        <h2 class="mt-2 text-balance font-serif text-3xl font-bold tracking-tight sm:text-4xl">Улюблені місця містян</h2>
                        <p class="mt-3 text-pretty leading-relaxed text-muted-foreground">Єдиний каталог підприємств міста — від кафе та магазинів до освіти, послуг і промисловості.</p>
                    </div>
                    <a href="/places" class="hidden shrink-0 items-center gap-1 text-sm font-medium text-muted-foreground transition-colors hover:text-foreground sm:inline-flex">
                        Усі заклади
                        <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 17L17 7M17 7H7M17 7v10"/></svg>
                    </a>
                </div>

                <div class="mt-8 flex flex-wrap gap-2">
                    @php
                        $categories = App\Services\ContentService::enterpriseCategories();
                    @endphp
                    <a href="/places" class="rounded-full bg-primary px-4 py-2 text-sm font-medium text-primary-foreground transition-colors">Усі</a>
                    @foreach($categories as $cat)
                        <a href="/places/category/{{ $cat['key'] }}" class="rounded-full border border-border bg-card px-4 py-2 text-sm font-medium text-muted-foreground transition-colors hover:text-foreground">{{ $cat['label'] }}</a>
                    @endforeach
                </div>

                <div class="mt-8 grid gap-6 md:grid-cols-3">
                    @php
                        $places = App\Services\ContentService::places();
                    @endphp
                    @foreach(array_slice($places, 0, 3) as $place)
                        <a href="/places/{{ $place['slug'] }}" class="group overflow-hidden rounded-2xl border border-border bg-card transition-colors hover:border-primary/40">
                            <div class="relative aspect-[16/10] overflow-hidden">
                                <img src="{{ $place['image'] }}" alt="{{ $place['name'] }}" class="h-full w-full object-cover transition-transform duration-500 group-hover:scale-105" loading="lazy" decoding="async">
                                <span class="absolute right-3 top-3 flex items-center gap-1 rounded-full bg-background/90 px-2.5 py-1 text-xs font-semibold backdrop-blur">
                                    <svg class="h-3.5 w-3.5 fill-accent text-accent" viewBox="0 0 24 24"><path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/></svg>
                                    {{ $place['rating'] }}
                                </span>
                            </div>
                            <div class="p-5">
                                <p class="text-xs font-medium text-primary">{{ $place['category'] }}</p>
                                <h3 class="mt-1.5 font-serif text-lg font-semibold">{{ $place['name'] }}</h3>
                                <p class="mt-2 flex items-center gap-1.5 text-sm text-muted-foreground">
                                    <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                                    {{ $place['area'] }}
                                </p>
                            </div>
                        </a>
                    @endforeach
                </div>
            </div>
        </section>

        {{-- Туристичний гід --}}
        <section id="tourism" class="border-t border-border bg-secondary/40">
            <div class="mx-auto max-w-6xl px-4 py-16 sm:px-6 sm:py-24">
                <div class="max-w-2xl">
                    <p class="text-sm font-medium text-primary">Туристичний гід</p>
                    <h2 class="mt-2 text-balance font-serif text-3xl font-bold tracking-tight sm:text-4xl">Що подивитися в місті</h2>
                    <p class="mt-3 text-pretty leading-relaxed text-muted-foreground">Від колиски українського театру до тінистих парків — знакові місця, які роблять Кропивницький особливим.</p>
                </div>

                <div class="mt-10 grid gap-6 lg:grid-cols-2">
                    @php
                        $landmarks = App\Services\ContentService::landmarks();
                    @endphp
                    @foreach($landmarks as $i => $item)
                        <a href="/city/{{ $item['slug'] }}" class="group relative overflow-hidden rounded-3xl border border-border {{ $i === 0 ? 'lg:row-span-2' : '' }}">
                            <div class="relative {{ $i === 0 ? 'aspect-[4/5] lg:aspect-auto lg:h-full' : 'aspect-[16/9]' }}">
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
            </div>
        </section>
@endsection
