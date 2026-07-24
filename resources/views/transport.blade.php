@extends('layouts.app')

@section('meta')
    <x-meta title="Транспорт — Кропивницький" description="Громадський транспорт міста" />
@endsection

@section('pageTitle', 'Транспорт — Кропивницький')
@section('pageDescription', 'Громадський транспорт міста Кропивницький: маршрути тролейбусів, електробусів та автобусів, електронний квиток і відстеження онлайн.')

@section('content')
<section class="border-b border-border bg-secondary/40">
    <div class="mx-auto max-w-6xl px-4 py-12 sm:px-6 sm:py-16">
        <nav aria-label="Хлібні крихти" class="flex items-center gap-1.5 text-sm text-muted-foreground">
            <span class="flex items-center gap-1.5">
                <a href="/" class="transition-colors hover:text-foreground">Головна</a>
            </span>
            <span class="flex items-center gap-1.5">
                <svg class="h-3.5 w-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                <span class="text-foreground">Транспорт</span>
            </span>
        </nav>
        <p class="mt-6 text-sm font-medium text-primary">Громадський транспорт</p>
        <h1 class="mt-2 text-balance font-serif text-4xl font-bold tracking-tight sm:text-5xl">Як пересуватися містом</h1>
        <p class="mt-4 max-w-2xl text-pretty text-lg leading-relaxed text-muted-foreground">Мережа тролейбусів, електробусів та автобусів з\u2019єднує всі райони міста. Оплата карткою, відстеження онлайн та зручні пересадки.</p>
    </div>
</section>

@php
    $info = App\Services\ContentService::transportInfo();
    $routes = App\Services\ContentService::transportRoutes();
@endphp

<section class="mx-auto max-w-6xl px-4 py-14 sm:px-6 sm:py-16">
    <div class="grid gap-5 sm:grid-cols-2 lg:grid-cols-4">
        @foreach($info as $item)
            <div class="rounded-2xl border border-border bg-card p-6">
                <span class="flex h-11 w-11 items-center justify-center rounded-xl bg-primary/10 text-primary">
                    @if($item['icon'] === 'CreditCard')
                        <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><rect x="1" y="4" width="22" height="16" rx="2"/><path d="M1 10h22"/></svg>
                    @elseif($item['icon'] === 'MapPin')
                        <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                    @elseif($item['icon'] === 'Accessibility')
                        <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><circle cx="16" cy="4" r="1"/><path d="m18 19 1-7-6 1M9 9l3-7 4 5 4-2M9 9l-4 6 5-1M9 15l4-6"/></svg>
                    @elseif($item['icon'] === 'Bike')
                        <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><circle cx="5.5" cy="17.5" r="3.5"/><circle cx="18.5" cy="17.5" r="3.5"/><path d="M15 6a1 1 0 100-2 1 1 0 000 2zm-3 11.5V14l-3-3 4-3 2 3h2"/></svg>
                    @else
                        <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                    @endif
                </span>
                <h3 class="mt-4 text-base font-semibold">{{ $item['title'] }}</h3>
                <p class="mt-2 text-sm leading-relaxed text-muted-foreground">{{ $item['text'] }}</p>
            </div>
        @endforeach
    </div>

    <div class="mt-14">
        <h2 class="font-serif text-2xl font-bold tracking-tight sm:text-3xl">Популярні маршрути</h2>
        <p class="mt-2 text-sm leading-relaxed text-muted-foreground">Актуальний розклад та інтервали руху основних маршрутів міста.</p>

        <div class="mt-8 flex flex-col gap-4 lg:flex-row lg:items-center lg:justify-between">
            <div class="flex flex-wrap gap-2" id="filter-buttons">
                <button data-filter="all" class="filter-btn rounded-full bg-primary px-4 py-2 text-sm font-medium text-primary-foreground transition-colors">Усі</button>
                <button data-filter="Тролейбус" class="filter-btn rounded-full border border-border bg-card px-4 py-2 text-sm font-medium text-muted-foreground transition-colors hover:text-foreground">Тролейбус</button>
                <button data-filter="Електробус" class="filter-btn rounded-full border border-border bg-card px-4 py-2 text-sm font-medium text-muted-foreground transition-colors hover:text-foreground">Електробус</button>
                <button data-filter="Автобус" class="filter-btn rounded-full border border-border bg-card px-4 py-2 text-sm font-medium text-muted-foreground transition-colors hover:text-foreground">Автобус</button>
                <button data-filter="Маршрутка" class="filter-btn rounded-full border border-border bg-card px-4 py-2 text-sm font-medium text-muted-foreground transition-colors hover:text-foreground">Маршрутка</button>
            </div>

            <div class="relative lg:w-72 lg:shrink-0">
                <svg class="pointer-events-none absolute left-3.5 top-1/2 h-4 w-4 -translate-y-1/2 text-muted-foreground" fill="none" stroke="currentColor" viewBox="0 0 24 24"><circle cx="11" cy="11" r="8"/><path d="M21 21l-4.35-4.35"/></svg>
                <input type="text" id="transport-search" placeholder="Пошук за номером або зупинкою…" aria-label="Пошук за номером або зупинкою" class="w-full rounded-full border border-border bg-card py-2.5 pl-10 pr-4 text-sm text-foreground outline-none transition-colors focus:border-primary">
            </div>
        </div>

        <p class="mt-6 text-sm text-muted-foreground">Знайдено маршрутів: <span class="font-semibold text-foreground" id="routes-count">{{ count($routes) }}</span></p>

        <div class="mt-6 grid gap-5 sm:grid-cols-2 lg:grid-cols-3" id="routes-grid">
            @foreach($routes as $route)
                @php
                    $typeClass = match($route['type']) {
                        'Тролейбус' => 'bg-blue-500/10 text-blue-500',
                        'Електробус' => 'bg-green-500/10 text-green-500',
                        'Автобус' => 'bg-amber-500/10 text-amber-500',
                        'Маршрутка' => 'bg-purple-500/10 text-purple-500',
                        default => 'bg-muted text-muted-foreground',
                    };
                @endphp
                <div data-type="{{ $route['type'] }}" data-number="{{ $route['number'] }}" data-from="{{ mb_strtolower($route['from']) }}" data-to="{{ mb_strtolower($route['to']) }}" class="route-card group rounded-2xl border border-border bg-card p-5 transition-all hover:border-primary/40">
                    <a href="{{ route('transport.show', $route['number']) }}" class="block">
                        <div class="flex items-start justify-between">
                            <span class="flex h-14 w-14 items-center justify-center rounded-xl bg-primary text-2xl font-bold text-primary-foreground">{{ $route['number'] }}</span>
                            <span class="rounded-full {{ $typeClass }} px-3 py-1 text-xs font-medium">{{ $route['type'] }}</span>
                        </div>
                        <div class="mt-4">
                            <div class="flex items-center gap-2 text-sm">
                                <span class="font-medium">{{ $route['from'] }}</span>
                                <svg class="h-4 w-4 shrink-0 text-muted-foreground" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg>
                                <span class="font-medium">{{ $route['to'] }}</span>
                            </div>
                            <div class="mt-3 flex items-center gap-2">
                                <svg class="h-4 w-4 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><path d="M12 6v6l4 2"/></svg>
                                <span class="text-sm text-muted-foreground">Інтервал: {{ $route['interval'] }}</span>
                            </div>
                        </div>
                    </a>
                    <a href="https://www.google.com/maps/dir/?api=1&destination={{ urlencode($route['from'] . ', Кропивницький') }}" target="_blank" rel="noopener noreferrer" onclick="event.stopPropagation()" class="mt-4 block w-full rounded-full bg-secondary px-4 py-2.5 text-center text-sm font-medium text-foreground transition-colors hover:bg-primary hover:text-primary-foreground">Прокласти маршрут</a>
                </div>
            @endforeach
        </div>
    </div>

    <section class="mt-14">
        <h2 class="font-serif text-2xl font-bold tracking-tight sm:text-3xl">Карта зупинок</h2>
        <p class="mt-2 text-sm leading-relaxed text-muted-foreground">Інтерактивна карта зупинок громадського транспорту міста Кропивницький.</p>
        <div class="mt-6 overflow-hidden rounded-2xl border border-border">
            <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d5306.0!2d32.2623!3d48.5079!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x0%3A0x0!2zNDjCsDMwJzI4LjQiTiAzMsKwMTUnNDQuMyJF!5e0!3m2!1suk!2sua!4v1" width="100%" height="450" style="border:0" allowfullscreen loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
        </div>
    </section>
</section>
@endsection

@section('scripts')
<script>
    const filterBtns = document.querySelectorAll('#filter-buttons .filter-btn');
    const searchInput = document.getElementById('transport-search');
    const grid = document.getElementById('routes-grid');
    const countEl = document.getElementById('routes-count');
    let activeFilter = 'all';

    function filterRoutes() {
        const query = searchInput.value.toLowerCase().trim();
        const cards = grid.querySelectorAll('.route-card');
        let visible = 0;
        cards.forEach(card => {
            const type = card.dataset.type;
            const number = card.dataset.number.toLowerCase();
            const from = card.dataset.from;
            const to = card.dataset.to;
            const matchesFilter = activeFilter === 'all' || type === activeFilter;
            const matchesSearch = !query || number.includes(query) || from.includes(query) || to.includes(query);
            const show = matchesFilter && matchesSearch;
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
            filterRoutes();
        });
    });

    searchInput.addEventListener('input', filterRoutes);
</script>
@endsection
