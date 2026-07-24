@extends('layouts.app')

@section('meta')
    <x-meta title="Про місто — Кропивницький" description="Історія, культура, економіка та пам'ятки міста Кропивницький у Центральній Україні" image="/images/hero-city.png" />
@endsection

@section('pageTitle', 'Про місто — Кропивницький')
@section('pageDescription', 'Історія, культура, економіка та пам\'ятки міста Кропивницький у Центральній Україні.')

@section('content')
<section class="border-b border-border bg-secondary/40">
    <div class="mx-auto max-w-6xl px-4 py-12 sm:px-6 sm:py-16">
        <x-breadcrumb :items="[['label' => 'Головна', 'href' => '/'], ['label' => 'Місто']]" />
        <p class="mt-6 text-sm font-medium text-primary">Про місто</p>
        <h1 class="mt-2 text-balance font-serif text-4xl font-bold tracking-tight sm:text-5xl">Кропивницький — місто, яке варто відкрити</h1>
        <p class="mt-4 rounded-2xl border border-border bg-card p-6 text-pretty text-lg leading-relaxed text-muted-foreground">Розташований у самому серці Центральної України на річці Інгул, Кропивницький поєднує багату театральну спадщину, зелені парки та затишну атмосферу міста з 272-річною історією. Заснований як військова фортеця, сьогодні він є обласним центром з населенням понад 215 000 мешканців.</p>
    </div>
</section>

@php
    $stats = App\Services\ContentService::stats();
    $landmarks = App\Services\ContentService::landmarks();
@endphp

<section class="mx-auto max-w-6xl px-4 py-14 sm:px-6 sm:py-16">
    <dl class="grid grid-cols-2 gap-6 rounded-3xl border border-border bg-card p-8 sm:grid-cols-4">
        @foreach($stats as $s)
            <div>
                <dt class="sr-only">{{ $s['label'] }}</dt>
                <dd class="font-serif text-3xl font-bold text-foreground sm:text-4xl">{{ $s['value'] }}</dd>
                <p class="mt-1 text-xs leading-snug text-muted-foreground">{{ $s['label'] }}</p>
            </div>
        @endforeach
    </dl>

    {{-- History Section --}}
    <div class="mt-16">
        <p class="text-sm font-medium text-primary">Історія</p>
        <h2 class="mt-2 text-balance font-serif text-3xl font-bold tracking-tight sm:text-4xl">Від фортеці до сучасного міста</h2>
        <p class="mt-3 max-w-2xl text-pretty text-muted-foreground leading-relaxed">Кропивницький має багату та бурхливу історію, що розпочалася з військової фортеці і пройшла через численні перейменування.</p>
    </div>

    <div class="mt-8 grid gap-6 sm:grid-cols-2 lg:grid-cols-4">
        <div class="rounded-2xl border border-border bg-card p-6">
            <span class="font-serif text-2xl font-bold text-primary">1754</span>
            <p class="mt-2 text-sm font-semibold text-foreground">Заснування</p>
            <p class="mt-1 text-sm leading-relaxed text-muted-foreground">Закладено Фортецю святої Єлисавети — базу для османського походу. Навколо неї почало формуватися поселення.</p>
        </div>
        <div class="rounded-2xl border border-border bg-card p-6">
            <span class="font-serif text-2xl font-bold text-primary">1784</span>
            <p class="mt-2 text-sm font-semibold text-foreground">Міський статус</p>
            <p class="mt-1 text-sm leading-relaxed text-muted-foreground">Поселення отримало статус міста під назвою Єлисаветград і стало повітовим центром.</p>
        </div>
        <div class="rounded-2xl border border-border bg-card p-6">
            <span class="font-serif text-2xl font-bold text-primary">1882</span>
            <p class="mt-2 text-sm font-semibold text-foreground">Театральна ера</p>
            <p class="mt-1 text-sm leading-relaxed text-muted-foreground">Марко Кропивницький відкрив перший професійний український театр — колиску національної сцени.</p>
        </div>
        <div class="rounded-2xl border border-border bg-card p-6">
            <span class="font-serif text-2xl font-bold text-primary">2016</span>
            <p class="mt-2 text-sm font-semibold text-foreground">Сучасна назва</p>
            <p class="mt-1 text-sm leading-relaxed text-muted-foreground">Місто перейменовано на Кропивницький на честь видатного театрального діяча.</p>
        </div>
    </div>

    {{-- Culture Section --}}
    <div class="mt-16">
        <p class="text-sm font-medium text-primary">Культура</p>
        <h2 class="mt-2 text-balance font-serif text-3xl font-bold tracking-tight sm:text-4xl">Театральна столиця України</h2>
        <p class="mt-3 max-w-2xl text-pretty text-muted-foreground leading-relaxed">Кропивницький відомий як батьківщина українського професійного театру. Культурне життя міста насичене протягом усього року.</p>
    </div>

    <div class="mt-8 grid gap-6 sm:grid-cols-3">
        <div class="rounded-2xl border border-border bg-card p-6">
            <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-primary/10">
                <svg class="h-5 w-5 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 5v2m0 4v2m0 4v2M5 5a2 2 0 00-2 2v3a2 2 0 110 4v3a2 2 0 002 2h14a2 2 0 002-2v-3a2 2 0 110-4V7a2 2 0 00-2-2H5z"/></svg>
            </div>
            <h3 class="mt-4 font-serif text-lg font-bold text-foreground">Театри</h3>
            <p class="mt-2 text-sm leading-relaxed text-muted-foreground">Драматичний театр ім. Кропивницького (найстаріший в Україні), Ляльковий театр, обласна філармонія. Щорічний театральний фестиваль «Вересневі самоцвіти».</p>
        </div>
        <div class="rounded-2xl border border-border bg-card p-6">
            <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-primary/10">
                <svg class="h-5 w-5 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/></svg>
            </div>
            <h3 class="mt-4 font-serif text-lg font-bold text-foreground">Музеї</h3>
            <p class="mt-2 text-sm leading-relaxed text-muted-foreground">Художній музей (засн. 1899), краєзнавчий музей, геологічний музей, музей історії армії. Понад 100 000 експонатів.</p>
        </div>
        <div class="rounded-2xl border border-border bg-card p-6">
            <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-primary/10">
                <svg class="h-5 w-5 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19V6l12-3v13M9 19c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zm12-3c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zM9 10l12-3"/></svg>
            </div>
            <h3 class="mt-4 font-serif text-lg font-bold text-foreground">Фестивалі</h3>
            <p class="mt-2 text-sm leading-relaxed text-muted-foreground">«Вересневі самоцвіти», гастрономічний фестиваль, музичні вечори просто неба, ярмарки ремесел та дитячі свята.</p>
        </div>
    </div>

    {{-- Economy Section --}}
    <div class="mt-16">
        <p class="text-sm font-medium text-primary">Економіка</p>
        <h2 class="mt-2 text-balance font-serif text-3xl font-bold tracking-tight sm:text-4xl">Промисловий та інноваційний центр</h2>
        <p class="mt-3 max-w-2xl text-pretty text-muted-foreground leading-relaxed">Кропивницький — важливий промисловий центр Центральної України з розвиненим машинобудуванням, харчовою промисловістю та електронікою.</p>
    </div>

    <div class="mt-8 grid gap-6 sm:grid-cols-2">
        <div class="rounded-2xl border border-border bg-card p-6">
            <h3 class="font-serif text-lg font-bold text-foreground">Промисловість</h3>
            <p class="mt-2 text-sm leading-relaxed text-muted-foreground">Понад 70 промислових підприємств: харчова промисловість, машинобудування, виробництво електроніки, текстилю та будівельних матеріалів.</p>
            <div class="mt-4 flex flex-wrap gap-2">
                <span class="inline-block rounded-full bg-primary/10 px-3 py-1 text-xs font-medium text-primary">Харчова</span>
                <span class="inline-block rounded-full bg-primary/10 px-3 py-1 text-xs font-medium text-primary">Машинобудування</span>
                <span class="inline-block rounded-full bg-primary/10 px-3 py-1 text-xs font-medium text-primary">Електроніка</span>
                <span class="inline-block rounded-full bg-primary/10 px-3 py-1 text-xs font-medium text-primary">Текстиль</span>
            </div>
        </div>
        <div class="rounded-2xl border border-border bg-card p-6">
            <h3 class="font-serif text-lg font-bold text-foreground">Сучасний розвиток</h3>
            <p class="mt-2 text-sm leading-relaxed text-muted-foreground">Активний розвиток IT-сектору, модернізація інфраструктури, оновлення громадського транспорту та створення нових робочих місць для молоді.</p>
            <div class="mt-4 flex flex-wrap gap-2">
                <span class="inline-block rounded-full bg-primary/10 px-3 py-1 text-xs font-medium text-primary">IT-сектор</span>
                <span class="inline-block rounded-full bg-primary/10 px-3 py-1 text-xs font-medium text-primary">Освіта</span>
                <span class="inline-block rounded-full bg-primary/10 px-3 py-1 text-xs font-medium text-primary">Стартапи</span>
            </div>
        </div>
    </div>

    {{-- Additional Info --}}
    <div class="mt-16 rounded-3xl border border-border bg-card p-8">
        <h2 class="font-serif text-2xl font-bold text-foreground">Місто в цифрах</h2>
        <div class="mt-6 grid gap-6 sm:grid-cols-2 lg:grid-cols-3">
            <div class="flex items-start gap-3">
                <svg class="mt-0.5 h-5 w-5 shrink-0 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                <div>
                    <p class="text-sm font-semibold text-foreground">Координати</p>
                    <p class="text-sm text-muted-foreground">48°30′36″N 32°16′00″E</p>
                </div>
            </div>
            <div class="flex items-start gap-3">
                <svg class="mt-0.5 h-5 w-5 shrink-0 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 15a4 4 0 004 4h9a5 5 0 10-.1-9.999 5.002 5.002 0 10-9.78 2.096A4.001 4.001 0 003 15z"/></svg>
                <div>
                    <p class="text-sm font-semibold text-foreground">Висота над рівнем моря</p>
                    <p class="text-sm text-muted-foreground">113 м</p>
                </div>
            </div>
            <div class="flex items-start gap-3">
                <svg class="mt-0.5 h-5 w-5 shrink-0 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/></svg>
                <div>
                    <p class="text-sm font-semibold text-foreground">Райони</p>
                    <p class="text-sm text-muted-foreground">Фортечний, Подільський</p>
                </div>
            </div>
            <div class="flex items-start gap-3">
                <svg class="mt-0.5 h-5 w-5 shrink-0 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/></svg>
                <div>
                    <p class="text-sm font-semibold text-foreground">Телефонний код</p>
                    <p class="text-sm text-muted-foreground">+380-522</p>
                </div>
            </div>
            <div class="flex items-start gap-3">
                <svg class="mt-0.5 h-5 w-5 shrink-0 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                <div>
                    <p class="text-sm font-semibold text-foreground">Поштові індекси</p>
                    <p class="text-sm text-muted-foreground">25000–25490</p>
                </div>
            </div>
            <div class="flex items-start gap-3">
                <svg class="mt-0.5 h-5 w-5 shrink-0 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                <div>
                    <p class="text-sm font-semibold text-foreground">День міста</p>
                    <p class="text-sm text-muted-foreground">Третя неділя вересня</p>
                </div>
            </div>
        </div>
        <div class="mt-6">
            <p class="text-sm font-semibold text-foreground">Побратими</p>
            <p class="mt-1 text-sm text-muted-foreground">Добрич (Болгарія), Шаосін (Китай), Крефельд (Німеччина)</p>
        </div>
    </div>

    {{-- Landmarks Section --}}
    <div class="mt-16">
        <p class="text-sm font-medium text-primary">Туристичний гід</p>
        <h2 class="mt-2 text-balance font-serif text-3xl font-bold tracking-tight sm:text-4xl">Що подивитися в місті</h2>
        <p class="mt-3 max-w-2xl text-pretty text-muted-foreground leading-relaxed">Кропивницький пропонує безліч пам'яток — від історичних фортець та церков до сучасних музеїв та парків.</p>
    </div>

    <div class="mt-8 grid gap-6 sm:grid-cols-2 lg:grid-cols-4">
        @foreach($landmarks as $item)
            <a href="{{ route('city.show', $item['slug']) }}" class="group relative overflow-hidden rounded-3xl border border-border">
                <div class="relative aspect-[4/3]">
                    <img src="{{ $item['image'] }}" alt="{{ $item['title'] }}" class="h-full w-full object-cover transition-transform duration-700 group-hover:scale-105" loading="lazy" decoding="async">
                    <div class="absolute inset-0 bg-gradient-to-t from-black/80 via-black/20 to-transparent" aria-hidden="true"></div>
                    <div class="absolute inset-x-0 bottom-0 p-4">
                        @if(isset($item['category']) && $item['category'])
                            <span class="inline-block rounded-full bg-white/20 px-2 py-0.5 text-xs font-medium text-white backdrop-blur-sm">
                                @if($item['category'] === 'theater') Театр
                                @elseif($item['category'] === 'museum') Музей
                                @elseif($item['category'] === 'park') Парк
                                @elseif($item['category'] === 'church') Храм
                                @elseif($item['category'] === 'history') Історія
                                @endif
                            </span>
                        @endif
                        <h3 class="mt-2 text-balance font-serif text-lg font-bold text-white leading-tight">{{ $item['title'] }}</h3>
                        <p class="mt-1 line-clamp-2 text-xs leading-relaxed text-white/80">{{ $item['description'] }}</p>
                        <span class="mt-2 inline-flex items-center gap-1 text-xs font-semibold text-white/90">
                            Дізнатися більше
                            <svg class="h-3 w-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg>
                        </span>
                    </div>
                </div>
            </a>
        @endforeach
    </div>
</section>
@endsection
