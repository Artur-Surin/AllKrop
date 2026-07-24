@extends('layouts.app')

@php
    $allRoutes = App\Services\ContentService::transportRoutes();
    $route = null;
    foreach ($allRoutes as $r) {
        if ($r['number'] === $number) {
            $route = $r;
            break;
        }
    }
    if (!$route) abort(404);

    $similarRoutes = array_filter($allRoutes, fn($r) => $r['type'] === $route['type'] && $r['number'] !== $route['number']);

    $typeClass = match($route['type']) {
        'Тролейбус' => 'bg-blue-500/10 text-blue-500',
        'Електробус' => 'bg-green-500/10 text-green-500',
        'Автобус' => 'bg-amber-500/10 text-amber-500',
        'Маршрутка' => 'bg-purple-500/10 text-purple-500',
        default => 'bg-muted text-muted-foreground',
    };

    $stops = match($route['number']) {
        '1' => ['Залізничний вокзал', 'вул. Ентузіастів', 'вул. Гоголя', 'пл. Героїв Майдану', 'вул. Тараса Карпи', 'вул. Космонавта Попова'],
        '3' => ['Центр', 'вул. Велика Перспективна', 'вул. Дворцова', 'Ковалівський парк', 'Житломасив «Ковалівка»'],
        '9' => ['Аеропорт', 'вул. Мурманська', 'вул. Пацаєва', 'вул. Шевченка', 'Центральна площа'],
        '14' => ['Пацаєва', 'вул. Генерала Жадова', 'вул. Архітектора Снігурьова', 'вул. Комарова', 'Лікарня швидкої допомоги'],
        '27' => ['Гірниче', 'вул. Генерала Алмазова', 'вул. Євгена Маланюка', 'вул. Ганни Барвінок', 'Центральний ринок'],
        '150' => ['Кропивницький', 'Автовокзал', 'смт Новгородка', 'смт Бобринець', 'Знам\'янка'],
        default => [$route['from'], 'Зупинка 2', 'Зупинка 3', 'Зупинка 4', $route['to']],
    };
@endphp

@section('meta')
    <x-meta title="Маршрут №{{ $route['number'] }} — Транспорт — Кропивницький" description="Маршрут №{{ $route['number'] }} {{ $route['type'] }}: {{ $route['from'] }} — {{ $route['to'] }}" />
@endsection

@section('pageTitle', 'Маршрут №' . $route['number'] . ' — Транспорт — Кропивницький')
@section('pageDescription', 'Маршрут №' . $route['number'] . ' ' . $route['type'] . ': ' . $route['from'] . ' — ' . $route['to'])

@section('content')
<div class="mx-auto max-w-6xl px-4 py-12 sm:px-6 sm:py-16">
    <div class="flex flex-wrap items-center gap-3 text-sm">
        <a href="{{ route('transport') }}" class="inline-flex items-center gap-1.5 font-medium text-muted-foreground transition-colors hover:text-foreground">
            <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 12H5M12 19l-7-7 7-7"/></svg>
            Транспорт
        </a>
    </div>

    <div class="mt-8 flex flex-col gap-8 lg:flex-row lg:items-start">
        <div class="flex-1">
            <div class="flex items-center gap-4">
                <span class="flex h-20 w-20 items-center justify-center rounded-2xl bg-primary text-4xl font-bold text-primary-foreground">{{ $route['number'] }}</span>
                <div>
                    <span class="rounded-full {{ $typeClass }} px-4 py-1.5 text-sm font-medium">{{ $route['type'] }}</span>
                    <h1 class="mt-2 text-balance font-serif text-3xl font-bold tracking-tight sm:text-4xl">Маршрут №{{ $route['number'] }}</h1>
                </div>
            </div>

            <div class="mt-8 flex items-center gap-3 rounded-2xl border border-border bg-card p-5">
                <div class="flex-1">
                    <p class="text-xs text-muted-foreground">Відправлення</p>
                    <p class="mt-1 font-serif text-lg font-semibold">{{ $route['from'] }}</p>
                </div>
                <svg class="h-6 w-6 shrink-0 text-muted-foreground" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg>
                <div class="flex-1 text-right">
                    <p class="text-xs text-muted-foreground">Прибуття</p>
                    <p class="mt-1 font-serif text-lg font-semibold">{{ $route['to'] }}</p>
                </div>
            </div>

            <div class="mt-6 flex items-center gap-4 text-sm text-muted-foreground">
                <span class="flex items-center gap-2">
                    <svg class="h-4 w-4 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><path d="M12 6v6l4 2"/></svg>
                    Інтервал: <span class="font-medium text-foreground">{{ $route['interval'] }}</span>
                </span>
                <span class="flex items-center gap-2">
                    <svg class="h-4 w-4 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                    {{ $route['type'] }}
                </span>
            </div>

            <a href="https://www.google.com/maps/dir/?api=1&destination={{ urlencode($route['from'] . ', Кропивницький') }}" target="_blank" rel="noopener noreferrer" class="mt-6 inline-flex items-center gap-2 rounded-full bg-primary px-6 py-3 text-sm font-semibold text-primary-foreground transition-transform hover:scale-[1.02]">
                <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0118 0z"/><circle cx="12" cy="10" r="3"/></svg>
                Прокласти маршрут
            </a>

            <section class="mt-10">
                <h2 class="font-serif text-xl font-bold tracking-tight">Зупинки маршруту</h2>
                <div class="mt-5 space-y-0">
                    @foreach($stops as $i => $stop)
                        <div class="relative flex items-start gap-4 pb-6">
                            @if(!$loop->last)
                                <div class="absolute left-[15px] top-8 h-full w-0.5 bg-border"></div>
                            @endif
                            <div class="relative z-10 flex h-8 w-8 shrink-0 items-center justify-center rounded-full {{ $loop->first || $loop->last ? 'bg-primary text-primary-foreground' : 'bg-secondary text-muted-foreground' }}">
                                @if($loop->first)
                                    <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 3l14 9-14 9V3z"/></svg>
                                @elseif($loop->last)
                                    <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 12h14M12 5l7 7-7 7"/></svg>
                                @else
                                    <span class="text-xs font-semibold">{{ $i }}</span>
                                @endif
                            </div>
                            <div class="pt-1">
                                <p class="font-medium text-foreground">{{ $stop }}</p>
                                @if($loop->first)
                                    <p class="mt-0.5 text-xs text-primary">Початкова зупинка</p>
                                @elseif($loop->last)
                                    <p class="mt-0.5 text-xs text-primary">Кінцева зупинка</p>
                                @endif
                            </div>
                        </div>
                    @endforeach
                </div>
            </section>
        </div>

        <aside class="w-full shrink-0 lg:w-80">
            <div class="rounded-2xl border border-border bg-card p-6">
                <p class="font-serif text-lg font-semibold">Інформація</p>
                <dl class="mt-5 space-y-4">
                    <div class="flex items-start gap-3">
                        <svg class="mt-0.5 h-5 w-5 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24"><rect x="3" y="4" width="18" height="18" rx="2"/><path d="M16 2v4M8 2v4M3 10h18"/></svg>
                        <div>
                            <dt class="text-xs text-muted-foreground">Номер маршруту</dt>
                            <dd class="text-sm font-medium">№{{ $route['number'] }}</dd>
                        </div>
                    </div>
                    <div class="flex items-start gap-3">
                        <svg class="mt-0.5 h-5 w-5 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                        <div>
                            <dt class="text-xs text-muted-foreground">Тип транспорту</dt>
                            <dd class="text-sm font-medium">{{ $route['type'] }}</dd>
                        </div>
                    </div>
                    <div class="flex items-start gap-3">
                        <svg class="mt-0.5 h-5 w-5 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><path d="M12 6v6l4 2"/></svg>
                        <div>
                            <dt class="text-xs text-muted-foreground">Інтервал руху</dt>
                            <dd class="text-sm font-medium">{{ $route['interval'] }}</dd>
                        </div>
                    </div>
                    <div class="flex items-start gap-3">
                        <svg class="mt-0.5 h-5 w-5 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                        <div>
                            <dt class="text-xs text-muted-foreground">Кількість зупинок</dt>
                            <dd class="text-sm font-medium">{{ count($stops) }}</dd>
                        </div>
                    </div>
                </dl>
            </div>

            @if(count($similarRoutes) > 0)
                <div class="mt-6 rounded-2xl border border-border bg-card p-6">
                    <p class="font-serif text-lg font-semibold">Схожі маршрути</p>
                    <div class="mt-4 space-y-3">
                        @foreach($similarRoutes as $similar)
                            <a href="{{ route('transport.show', $similar['number']) }}" class="flex items-center gap-3 rounded-xl border border-border p-3 transition-colors hover:border-primary/40">
                                <span class="flex h-10 w-10 shrink-0 items-center justify-center rounded-lg bg-primary text-sm font-bold text-primary-foreground">{{ $similar['number'] }}</span>
                                <div class="min-w-0 flex-1">
                                    <p class="truncate text-sm font-medium">{{ $similar['from'] }} — {{ $similar['to'] }}</p>
                                    <p class="mt-0.5 text-xs text-muted-foreground">{{ $similar['interval'] }}</p>
                                </div>
                            </a>
                        @endforeach
                    </div>
                </div>
            @endif
        </aside>
    </div>
</div>
@endsection
