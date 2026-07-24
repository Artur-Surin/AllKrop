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

        <div class="mt-6 overflow-hidden rounded-2xl border border-border">
            <table class="w-full text-left text-sm">
                <thead class="bg-secondary/60 text-muted-foreground">
                    <tr>
                        <th scope="col" class="px-4 py-3 font-medium sm:px-6">Маршрут</th>
                        <th scope="col" class="px-4 py-3 font-medium sm:px-6">Тип</th>
                        <th scope="col" class="hidden px-4 py-3 font-medium sm:table-cell sm:px-6">Напрямок</th>
                        <th scope="col" class="px-4 py-3 font-medium sm:px-6">Інтервал</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-border">
                    @foreach($routes as $route)
                        <tr class="bg-card transition-colors hover:bg-secondary/30">
                            <td class="px-4 py-4 sm:px-6">
                                <span class="inline-flex h-9 min-w-9 items-center justify-center rounded-lg bg-primary px-2 text-sm font-bold text-primary-foreground">{{ $route['number'] }}</span>
                            </td>
                            <td class="px-4 py-4 text-muted-foreground sm:px-6">{{ $route['type'] }}</td>
                            <td class="hidden px-4 py-4 sm:table-cell sm:px-6">
                                <span class="font-medium text-foreground">{{ $route['from'] }}</span>
                                <span class="text-muted-foreground"> — {{ $route['to'] }}</span>
                            </td>
                            <td class="px-4 py-4 font-medium sm:px-6">{{ $route['interval'] }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</section>
@endsection
