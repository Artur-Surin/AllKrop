@extends('layouts.app')

@section('meta')
    <x-meta title="Каталог підприємств — Кропивницький" description="Повний каталог підприємств міста" image="/images/hero-city.png" />
@endsection

@section('pageTitle', 'Каталог підприємств — Кропивницький')
@section('pageDescription', 'Повний каталог підприємств міста Кропивницький: кафе та ресторани, магазини, культура, краса та здоров\u2019я, освіта, авто, послуги та промисловість.')

@section('content')
<section class="border-b border-border bg-secondary/40">
    <div class="mx-auto max-w-6xl px-4 py-12 sm:px-6 sm:py-16">
        <x-breadcrumb :items="[['label' => 'Головна', 'href' => '/'], ['label' => 'Заклади']]" />
        <p class="mt-6 text-sm font-medium text-primary">Каталог підприємств</p>
        <h1 class="mt-2 text-balance font-serif text-4xl font-bold tracking-tight sm:text-5xl">Усі підприємства міста</h1>
        <p class="mt-4 max-w-2xl text-pretty text-lg leading-relaxed text-muted-foreground">Єдиний довідник закладів та компаній Кропивницького — обирайте категорію або шукайте потрібне підприємство за назвою.</p>
    </div>
</section>

@php
    $categories = App\Services\ContentService::enterpriseCategories();
@endphp

<section class="border-b border-border bg-secondary/40">
    <div class="mx-auto max-w-6xl px-4 py-14 sm:px-6 sm:py-16">
        <div class="max-w-2xl">
            <h2 class="text-balance font-serif text-2xl font-bold tracking-tight sm:text-3xl">Категорії підприємств</h2>
            <p class="mt-2 text-pretty leading-relaxed text-muted-foreground">Оберіть напрям, щоб переглянути всі підприємства міста у вибраній категорії.</p>
        </div>

        <div class="mt-8 grid gap-4 sm:grid-cols-2 lg:grid-cols-4">
            @foreach($categories as $cat)
                <a href="{{ route('places.category', $cat['key']) }}" class="group flex flex-col rounded-2xl border border-border bg-card p-5 transition-colors hover:border-primary/40">
                    <div class="flex items-center justify-between">
                        <span class="flex h-11 w-11 items-center justify-center rounded-xl bg-primary/10 text-primary">
                            @if($cat['icon'] === 'UtensilsCrossed')
                                <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M3 2v7c0 1.1.9 2 2 2h4a2 2 0 002-2V2M7 2v20M21 15V2v0a5 5 0 00-5 5v6c0 1.1.9 2 2 2h3zm0 0v7"/></svg>
                            @elseif($cat['icon'] === 'ShoppingBag')
                                <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M6 2L3 6v14a2 2 0 002 2h14a2 2 0 002-2V6l-3-4zM3 6h18M16 10a4 4 0 01-8 0"/></svg>
                            @elseif($cat['icon'] === 'Drama')
                                <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><path d="M8 14s1.5 2 4 2 4-2 4-2M9 9h.01M15 9h.01"/></svg>
                            @elseif($cat['icon'] === 'HeartPulse')
                                <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M19.5 12.572l-7.5 7.428l-7.5 -7.428a5 5 0 1 1 7.5 -6.566a5 5 0 1 1 7.5 6.572"/><path d="M12 7l-2 4l4 0l-2 4"/></svg>
                            @elseif($cat['icon'] === 'GraduationCap')
                                <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M22 10l-10-5L2 10l10 5l10-5zM6 12v5c3 3 9 3 12 0v-5"/></svg>
                            @elseif($cat['icon'] === 'Car')
                                <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M14 16H9m10 0h3v-3.15a1 1 0 00-.84-.99L16 11l-2.7-3.6a1 1 0 00-.8-.4H5.24a2 2 0 00-1.8 1.1l-.8 1.63A6 6 0 002 12.42V16h2M7 16a2 2 0 104 0m8 0a2 2 0 10-4 0"/></svg>
                            @elseif($cat['icon'] === 'Briefcase')
                                <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><rect x="2" y="7" width="20" height="14" rx="2"/><path d="M16 7V5a2 2 0 00-2-2h-4a2 2 0 00-2 2v2"/></svg>
                            @elseif($cat['icon'] === 'Factory')
                                <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M2 20V8l5 4V8l5 4V4h8v16H2z"/></svg>
                            @endif
                        </span>
                        <svg class="h-5 w-5 text-muted-foreground transition-colors group-hover:text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 17L17 7M17 7H7M17 7v10"/></svg>
                    </div>
                    <h3 class="mt-4 font-serif text-lg font-semibold">{{ $cat['label'] }}</h3>
                    <p class="mt-1.5 flex-1 text-sm leading-relaxed text-muted-foreground">{{ $cat['description'] }}</p>
                    <p class="mt-4 text-xs font-medium text-primary">{{ App\Services\ContentService::categoryCount($cat['key']) }} підприємств</p>
                </a>
            @endforeach
        </div>
    </div>
</section>

<div class="mx-auto max-w-6xl px-4 py-14 sm:px-6 sm:py-16">
    <div class="flex flex-col gap-4 lg:flex-row lg:items-center lg:justify-between">
        <div class="flex flex-wrap gap-2" id="filter-buttons">
            <button data-filter="all" class="filter-btn rounded-full px-4 py-2 text-sm font-medium transition-colors bg-primary text-primary-foreground">Усі</button>
            @foreach($categories as $cat)
                <button data-filter="{{ $cat['key'] }}" class="filter-btn rounded-full border border-border bg-card px-4 py-2 text-sm font-medium text-muted-foreground transition-colors hover:text-foreground">{{ $cat['label'] }}</button>
            @endforeach
        </div>
    </div>

    <p class="mt-6 text-sm text-muted-foreground">Знайдено підприємств: <span class="font-semibold text-foreground" id="places-count">{{ $places->total() }}</span></p>

    <div class="mt-6 grid gap-6 md:grid-cols-2 lg:grid-cols-3" id="places-grid">
        @foreach($places as $place)
            <a href="{{ route('places.show', $place->slug) }}" data-category="{{ $place->category?->key ?? '' }}" data-name="{{ mb_strtolower($place->name) }}" class="place-card group overflow-hidden rounded-2xl border border-border bg-card transition-colors hover:border-primary/40">
                <div class="relative aspect-[16/10] overflow-hidden">
                    <img src="{{ $place->image }}" alt="{{ $place->name }}" class="h-full w-full object-cover transition-transform duration-500 group-hover:scale-105" loading="lazy" decoding="async">
                    <span class="absolute right-3 top-3 flex items-center gap-1 rounded-full bg-background/90 px-2.5 py-1 text-xs font-semibold backdrop-blur">
                        <svg class="h-3.5 w-3.5 fill-accent text-accent" viewBox="0 0 24 24"><path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/></svg>
                        {{ $place->rating }}
                    </span>
                </div>
                <div class="p-5">
                    <p class="text-xs font-medium text-primary">{{ $place->category->label ?? '' }}</p>
                    <h3 class="mt-1.5 font-serif text-lg font-semibold">{{ $place->name }}</h3>
                    <p class="mt-2 flex items-center gap-1.5 text-sm text-muted-foreground">
                        <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                        {{ $place->area }}
                    </p>
                </div>
            </a>
        @endforeach
    </div>

    <div class="mt-10 flex flex-col items-center gap-3 sm:flex-row sm:justify-between">
        <a href="{{ $places->previousPageUrl() }}" class="inline-flex items-center gap-1.5 rounded-full border border-border px-4 py-2 text-sm font-medium text-muted-foreground transition-colors hover:bg-secondary hover:text-foreground {{ $places->onFirstPage() ? 'pointer-events-none opacity-50' : '' }}">
            « Попередня
        </a>

        <span class="text-sm text-muted-foreground">
            Показано {{ $places->firstItem() }}–{{ $places->lastItem() }} з {{ $places->total() }} результатів
        </span>

        <a href="{{ $places->nextPageUrl() }}" class="inline-flex items-center gap-1.5 rounded-full border border-border px-4 py-2 text-sm font-medium text-muted-foreground transition-colors hover:bg-secondary hover:text-foreground {{ $places->hasMorePages() ? '' : 'pointer-events-none opacity-50' }}">
            Наступна »
        </a>
    </div>
</div>
@endsection

@section('scripts')
<script>
    const filterBtns = document.querySelectorAll('#filter-buttons .filter-btn');
    const grid = document.getElementById('places-grid');
    const countEl = document.getElementById('places-count');
    let activeFilter = 'all';

    function filterPlaces() {
        const cards = grid.querySelectorAll('.place-card');
        let visible = 0;
        cards.forEach(card => {
            const cat = card.dataset.category;
            const show = activeFilter === 'all' || cat === activeFilter;
            card.style.display = show ? '' : 'none';
            if (show) visible++;
        });
        countEl.textContent = visible;
    }

    filterBtns.forEach(btn => {
        btn.addEventListener('click', () => {
            activeFilter = btn.dataset.filter;
            filterBtns.forEach(b => {
                b.classList.remove('bg-primary', 'text-primary-foreground');
                b.classList.add('border', 'border-border', 'bg-card', 'text-muted-foreground');
            });
            btn.classList.add('bg-primary', 'text-primary-foreground');
            btn.classList.remove('border', 'border-border', 'bg-card', 'text-muted-foreground');
            filterPlaces();
        });
    });
</script>
@endsection
