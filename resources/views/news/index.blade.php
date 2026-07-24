@extends('layouts.app')

@section('meta')
    <x-meta title="Новини — Кропивницький" description="Свіжі новини міста Кропивницький" image="/images/hero-city.png" />
@endsection

@section('pageTitle', 'Новини — Кропивницький')
@section('pageDescription', 'Свіжі новини міста Кропивницький: місто, транспорт, культура, спорт та життя громади.')

@section('content')
<section class="border-b border-border bg-secondary/40">
    <div class="mx-auto max-w-6xl px-4 py-12 sm:px-6 sm:py-16">
        <x-breadcrumb :items="[['label' => 'Головна', 'href' => '/'], ['label' => 'Новини']]" />
        <p class="mt-6 text-sm font-medium text-primary">Новини міста</p>
        <h1 class="mt-2 text-balance font-serif text-4xl font-bold tracking-tight sm:text-5xl">Що відбувається у Кропивницькому</h1>
        <p class="mt-4 max-w-2xl text-pretty text-lg leading-relaxed text-muted-foreground">Головні події, оновлення інфраструктури, культура та життя громади — усе найважливіше в одному місці.</p>
    </div>
</section>

<div class="mx-auto max-w-6xl px-4 py-14 sm:px-6 sm:py-16">
    @if($news->count() > 0)
        <a href="{{ route('news.show', $news[0]->slug) }}" class="group grid overflow-hidden rounded-3xl border border-border bg-card transition-colors hover:border-primary/40 lg:grid-cols-2">
            <div class="relative aspect-[16/10] overflow-hidden lg:aspect-auto">
                <img src="{{ $news[0]->image }}" alt="{{ $news[0]->title }}" class="h-full w-full object-cover transition-transform duration-500 group-hover:scale-105" loading="lazy" decoding="async">
            </div>
            <div class="flex flex-col justify-center p-6 sm:p-10">
                <span class="w-fit rounded-full bg-secondary px-3 py-1 text-xs font-medium text-secondary-foreground">{{ $news[0]->tag }}</span>
                <h2 class="mt-4 text-balance font-serif text-2xl font-bold leading-snug sm:text-3xl">{{ $news[0]->title }}</h2>
                <p class="mt-3 text-pretty leading-relaxed text-muted-foreground">{{ $news[0]->excerpt }}</p>
                <div class="mt-6 flex items-center gap-4 text-xs text-muted-foreground">
                    <span>{{ $news[0]->date }}</span>
                    <span class="flex items-center gap-1">
                        <svg class="h-3.5 w-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><path d="M12 6v6l4 2"/></svg>
                        {{ $news[0]->read_time }} читання
                    </span>
                </div>
            </div>
        </a>

        <div class="mt-8 grid gap-5 md:grid-cols-2 lg:grid-cols-3">
            @foreach($news->slice(1) as $item)
                <a href="{{ route('news.show', $item->slug) }}" class="group flex flex-col overflow-hidden rounded-2xl border border-border bg-card transition-colors hover:border-primary/40">
                    <div class="relative aspect-[16/10] overflow-hidden">
                        <img src="{{ $item->image }}" alt="{{ $item->title }}" class="h-full w-full object-cover transition-transform duration-500 group-hover:scale-105" loading="lazy" decoding="async">
                        <span class="absolute left-3 top-3 rounded-full bg-background/90 px-3 py-1 text-xs font-medium backdrop-blur">{{ $item->tag }}</span>
                    </div>
                    <div class="flex flex-1 flex-col p-6">
                        <h3 class="text-pretty font-serif text-lg font-semibold leading-snug">{{ $item->title }}</h3>
                        <p class="mt-3 flex-1 text-sm leading-relaxed text-muted-foreground">{{ $item->excerpt }}</p>
                        <div class="mt-5 flex items-center justify-between border-t border-border pt-4 text-xs text-muted-foreground">
                            <span>{{ $item->date }}</span>
                            <svg class="h-4 w-4 transition-transform group-hover:-translate-y-0.5 group-hover:translate-x-0.5 group-hover:text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 17L17 7M17 7H7M17 7v10"/></svg>
                        </div>
                    </div>
                </a>
            @endforeach
        </div>
    @else
        <p class="text-center text-muted-foreground">Новин поки немає.</p>
    @endif

    <div class="mt-10">
        {{ $news->links() }}
    </div>
</div>
@endsection
