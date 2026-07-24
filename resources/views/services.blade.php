@extends('layouts.app')

@section('meta')
    <x-meta title="Послуги — Кропивницький" description="Електронні послуги міста" />
@endsection

@section('pageTitle', 'Послуги — Кропивницький')
@section('pageDescription', 'Електронні послуги міста Кропивницький: довідки, реєстрація, комунальні платежі, звернення до міськради та громадський бюджет.')

@section('content')
<section class="border-b border-border bg-secondary/40">
    <div class="mx-auto max-w-6xl px-4 py-12 sm:px-6 sm:py-16">
        <nav aria-label="Хлібні крихти" class="flex items-center gap-1.5 text-sm text-muted-foreground">
            <span class="flex items-center gap-1.5">
                <a href="/" class="transition-colors hover:text-foreground">Головна</a>
            </span>
            <span class="flex items-center gap-1.5">
                <svg class="h-3.5 w-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                <span class="text-foreground">Послуги</span>
            </span>
        </nav>
        <p class="mt-6 text-sm font-medium text-primary">Електронні послуги</p>
        <h1 class="mt-2 text-balance font-serif text-4xl font-bold tracking-tight sm:text-5xl">Міські послуги онлайн</h1>
        <p class="mt-4 max-w-2xl text-pretty text-lg leading-relaxed text-muted-foreground">Замовляйте документи, сплачуйте комунальні, звертайтеся до міськради та беріть участь у житті громади — без черг і паперів.</p>
    </div>
</section>

@php
    $serviceGroups = App\Services\ContentService::serviceGroups();
@endphp

<section class="mx-auto max-w-6xl px-4 py-14 sm:px-6 sm:py-16">
    <div class="space-y-14">
        @foreach($serviceGroups as $group)
            <div>
                <h2 class="font-serif text-2xl font-bold tracking-tight sm:text-3xl">{{ $group['category'] }}</h2>
                <div class="mt-6 grid gap-5 sm:grid-cols-2 lg:grid-cols-3">
                    @foreach($group['items'] as $item)
                        <article class="group flex flex-col rounded-2xl border border-border bg-card p-6 transition-colors hover:border-primary/40">
                            <span class="flex h-11 w-11 items-center justify-center rounded-xl bg-primary/10 text-primary">
                                @if($item['icon'] === 'FileText')
                                    <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M14 2H6a2 2 0 00-2 2v16a2 2 0 002 2h12a2 2 0 002-2V8z"/><path d="M14 2v6h6M16 13H8M16 17H8M10 9H8"/></svg>
                                @elseif($item['icon'] === 'Home')
                                    <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M3 9l9-7 9 7v11a2 2 0 01-2 2H5a2 2 0 01-2-2z"/><path d="M9 22V12h6v10"/></svg>
                                @elseif($item['icon'] === 'Baby')
                                    <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M9 12h.01M15 12h.01M10 16c.5.3 1.2.5 2 .5s1.5-.2 2-.5M19 6.3a9 9 0 011.8 3.7 4.4 4.4 0 01-2.3 7.8 4.4 4.4 0 01-3.5 1.8 4.4 4.4 0 01-3.5-1.8 4.4 4.4 0 01-2.3-7.8A9 9 0 015 6.3"/></svg>
                                @elseif($item['icon'] === 'Receipt')
                                    <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M4 2v20l3-2 3 2 3-2 3 2 3-2 3 2V2l-3 2-3-2-3 2-3-2-3 2-3-2z"/><path d="M8 10h8M8 14h4"/></svg>
                                @elseif($item['icon'] === 'Wrench')
                                    <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M14.7 6.3a1 1 0 000 1.4l1.6 1.6a1 1 0 001.4 0l3.77-3.77a6 6 0 01-7.94 7.94l-6.91 6.91a2.12 2.12 0 01-3-3l6.91-6.91a6 6 0 017.94-7.94l-3.76 3.76z"/></svg>
                                @elseif($item['icon'] === 'HandCoins')
                                    <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M12 2v20M17 5H9.5a3.5 3.5 0 000 7h5a3.5 3.5 0 010 7H6"/></svg>
                                @elseif($item['icon'] === 'MessageSquare')
                                    <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M21 15a2 2 0 01-2 2H7l-4 4V5a2 2 0 012-2h14a2 2 0 012 2z"/></svg>
                                @elseif($item['icon'] === 'Vote')
                                    <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M4 15s1-1 4-1 5 2 8 2 4-1 4-1V3s-1 1-4 1-5-2-8-2-4 1-4 1z"/><line x1="4" y1="22" x2="4" y2="15"/></svg>
                                @elseif($item['icon'] === 'Phone')
                                    <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M22 16.92v3a2 2 0 01-2.18 2 19.79 19.79 0 01-8.63-3.07 19.5 19.5 0 01-6-6 19.79 19.79 0 01-3.07-8.67A2 2 0 014.11 2h3a2 2 0 012 1.72c.127.96.361 1.903.7 2.81a2 2 0 01-.45 2.11L8.09 9.91a16 16 0 006 6l1.27-1.27a2 2 0 012.11-.45c.907.339 1.85.573 2.81.7A2 2 0 0122 16.92z"/></svg>
                                @else
                                    <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M14 2H6a2 2 0 00-2 2v16a2 2 0 002 2h12a2 2 0 002-2V8z"/><path d="M14 2v6h6M16 13H8M16 17H8M10 9H8"/></svg>
                                @endif
                            </span>
                            <h3 class="mt-4 text-lg font-semibold">{{ $item['title'] }}</h3>
                            <p class="mt-2 flex-1 text-sm leading-relaxed text-muted-foreground">{{ $item['description'] }}</p>
                            <button class="mt-5 inline-flex items-center gap-1.5 self-start text-sm font-semibold text-primary transition-transform group-hover:translate-x-0.5">
                                {{ $item['action'] }}
                                <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg>
                            </button>
                        </article>
                    @endforeach
                </div>
            </div>
        @endforeach
    </div>

    <div class="mt-14 flex flex-col items-start gap-4 rounded-3xl border border-border bg-secondary/40 p-8 sm:flex-row sm:items-center sm:justify-between">
        <div>
            <h2 class="font-serif text-2xl font-bold tracking-tight">Не знайшли потрібну послугу?</h2>
            <p class="mt-2 max-w-xl text-sm leading-relaxed text-muted-foreground">Зверніться до Центру надання адміністративних послуг або скористайтеся контакт-центром міста для консультації.</p>
        </div>
        <a href="{{ route('contacts') }}" class="inline-flex shrink-0 items-center justify-center gap-2 rounded-full bg-primary px-6 py-3.5 text-sm font-semibold text-primary-foreground transition-transform hover:scale-[1.02]">
            До контактів
            <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg>
        </a>
    </div>
</section>
@endsection
