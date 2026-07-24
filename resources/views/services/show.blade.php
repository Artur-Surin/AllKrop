@extends('layouts.app')

@section('meta')
    <x-meta title="{{ $service['title'] }} — Послуги — Кропивницький" description="{{ $service['description'] }}" image="/images/hero-city.png" />
@endsection

@section('pageTitle', $service['title'] . ' — Послуги')
@section('pageDescription', $service['description'])

@section('content')
<section class="border-b border-border bg-secondary/40">
    <div class="mx-auto max-w-6xl px-4 py-12 sm:px-6 sm:py-16">
        <x-breadcrumb :items="[['label' => 'Головна', 'href' => '/'], ['label' => 'Послуги', 'href' => route('services')], ['label' => $service['title']]]" />

        <div class="mt-8 flex items-start gap-4">
            <span class="flex h-14 w-14 shrink-0 items-center justify-center rounded-2xl bg-primary/10 text-primary">
                @if($service['icon'] === 'FileText')
                    <svg class="h-7 w-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M14 2H6a2 2 0 00-2 2v16a2 2 0 002 2h12a2 2 0 002-2V8z"/><path d="M14 2v6h6M16 13H8M16 17H8M10 9H8"/></svg>
                @elseif($service['icon'] === 'Home')
                    <svg class="h-7 w-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M3 9l9-7 9 7v11a2 2 0 01-2 2H5a2 2 0 01-2-2z"/><path d="M9 22V12h6v10"/></svg>
                @elseif($service['icon'] === 'Baby')
                    <svg class="h-7 w-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M9 12h.01M15 12h.01M10 16c.5.3 1.2.5 2 .5s1.5-.2 2-.5M19 6.3a9 9 0 011.8 3.7 4.4 4.4 0 01-2.3 7.8 4.4 4.4 0 01-3.5 1.8 4.4 4.4 0 01-3.5-1.8 4.4 4.4 0 01-2.3-7.8A9 9 0 015 6.3"/></svg>
                @elseif($service['icon'] === 'Receipt')
                    <svg class="h-7 w-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M4 2v20l3-2 3 2 3-2 3 2 3-2 3 2V2l-3 2-3-2-3 2-3-2-3 2-3-2z"/><path d="M8 10h8M8 14h4"/></svg>
                @elseif($service['icon'] === 'Wrench')
                    <svg class="h-7 w-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M14.7 6.3a1 1 0 000 1.4l1.6 1.6a1 1 0 001.4 0l3.77-3.77a6 6 0 01-7.94 7.94l-6.91 6.91a2.12 2.12 0 01-3-3l6.91-6.91a6 6 0 017.94-7.94l-3.76 3.76z"/></svg>
                @elseif($service['icon'] === 'HandCoins')
                    <svg class="h-7 w-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M12 2v20M17 5H9.5a3.5 3.5 0 000 7h5a3.5 3.5 0 010 7H6"/></svg>
                @elseif($service['icon'] === 'MessageSquare')
                    <svg class="h-7 w-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M21 15a2 2 0 01-2 2H7l-4 4V5a2 2 0 012-2h14a2 2 0 012 2z"/></svg>
                @elseif($service['icon'] === 'Vote')
                    <svg class="h-7 w-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M4 15s1-1 4-1 5 2 8 2 4-1 4-1V3s-1 1-4 1-5-2-8-2-4 1-4 1z"/><line x1="4" y1="22" x2="4" y2="15"/></svg>
                @elseif($service['icon'] === 'Phone')
                    <svg class="h-7 w-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M22 16.92v3a2 2 0 01-2.18 2 19.79 19.79 0 01-8.63-3.07 19.5 19.5 0 01-6-6 19.79 19.79 0 01-3.07-8.67A2 2 0 014.11 2h3a2 2 0 012 1.72c.127.96.361 1.903.7 2.81a2 2 0 01-.45 2.11L8.09 9.91a16 16 0 006 6l1.27-1.27a2 2 0 012.11-.45c.907.339 1.85.573 2.81.7A2 2 0 0122 16.92z"/></svg>
                @else
                    <svg class="h-7 w-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M14 2H6a2 2 0 00-2 2v16a2 2 0 002 2h12a2 2 0 002-2V8z"/><path d="M14 2v6h6M16 13H8M16 17H8M10 9H8"/></svg>
                @endif
            </span>
            <div>
                <p class="text-sm font-medium text-primary">{{ $service['group_category'] }}</p>
                <h1 class="mt-1 font-serif text-3xl font-bold tracking-tight sm:text-4xl">{{ $service['title'] }}</h1>
                <p class="mt-3 max-w-2xl text-lg text-muted-foreground">{{ $service['description'] }}</p>
            </div>
        </div>
    </div>
</section>

<div class="mx-auto max-w-6xl px-4 py-10 sm:px-6">
    <div class="grid gap-8 lg:grid-cols-3">
        {{-- Main Content --}}
        <div class="lg:col-span-2 space-y-8">

            {{-- Institution Notice --}}
            <div class="rounded-2xl border border-primary/20 bg-primary/5 p-6">
                <div class="flex items-start gap-3">
                    <span class="flex h-9 w-9 shrink-0 items-center justify-center rounded-xl bg-primary/10 text-primary">
                        <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    </span>
                    <div>
                        <p class="text-sm font-semibold">Цю послугу надає установа міста</p>
                        <p class="mt-1 text-sm text-muted-foreground">Портал надає інформацію. Для отримання послуги зверніться безпосередньо до відповідної установи.</p>
                    </div>
                </div>
            </div>

            {{-- Steps --}}
            @if(!empty($service['steps']))
            <div class="rounded-2xl border border-border bg-card p-6">
                <h2 class="flex items-center gap-2 font-serif text-xl font-bold tracking-tight">
                    <svg class="h-5 w-5 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/></svg>
                    Як отримати в установі
                </h2>
                <ol class="mt-5 space-y-4">
                    @foreach($service['steps'] as $i => $step)
                        <li class="flex items-start gap-3">
                            <span class="flex h-7 w-7 shrink-0 items-center justify-center rounded-full bg-primary/10 text-xs font-bold text-primary">{{ $i + 1 }}</span>
                            <span class="pt-0.5 text-sm leading-relaxed text-muted-foreground">{{ $step }}</span>
                        </li>
                    @endforeach
                </ol>
            </div>
            @endif

            {{-- Documents --}}
            @if(!empty($service['documents']) && $service['documents'] !== ['Не потрібно'])
            <div class="rounded-2xl border border-border bg-card p-6">
                <h2 class="flex items-center gap-2 font-serif text-xl font-bold tracking-tight">
                    <svg class="h-5 w-5 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                    Необхідні документи
                </h2>
                <ul class="mt-5 space-y-3">
                    @foreach($service['documents'] as $doc)
                        <li class="flex items-start gap-2.5">
                            <svg class="mt-0.5 h-4 w-4 shrink-0 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                            <span class="text-sm text-muted-foreground">{{ $doc }}</span>
                        </li>
                    @endforeach
                </ul>
            </div>
            @endif

            {{-- FAQ --}}
            @if(!empty($service['faq']))
            <div class="rounded-2xl border border-border bg-card p-6">
                <h2 class="flex items-center gap-2 font-serif text-xl font-bold tracking-tight">
                    <svg class="h-5 w-5 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    Часті питання
                </h2>
                <div class="mt-5 divide-y divide-border">
                    @foreach($service['faq'] as $faq)
                        <div class="faq-item py-4">
                            <button class="faq-toggle flex w-full items-center justify-between gap-3 text-left text-sm font-semibold" onclick="this.parentElement.classList.toggle('open')">
                                <span>{{ $faq['q'] }}</span>
                                <svg class="faq-chevron h-4 w-4 shrink-0 text-muted-foreground transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                            </button>
                            <div class="faq-answer mt-2 max-h-0 overflow-hidden transition-all duration-300">
                                <p class="text-sm leading-relaxed text-muted-foreground">{{ $faq['a'] }}</p>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
            @endif
        </div>

        {{-- Sidebar --}}
        <div class="space-y-6">

            {{-- Go to Institution Button --}}
            @if(!empty($service['url']))
            <div class="rounded-2xl border border-border bg-card p-6">
                <a
                    href="{{ $service['url'] }}"
                    target="_blank"
                    rel="noopener noreferrer"
                    class="flex w-full items-center justify-center gap-2 rounded-full bg-primary px-5 py-3 text-sm font-semibold text-primary-foreground transition-transform hover:scale-[1.02]"
                >
                    Перейти на сайт установи
                    <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/></svg>
                </a>
            </div>
            @endif

            {{-- Institution Info Card --}}
            @if($institution)
            <div class="rounded-2xl border border-border bg-card p-6">
                <h3 class="font-semibold">Установа</h3>
                <div class="mt-4 space-y-4">
                    <div class="flex items-start gap-3">
                        <span class="flex h-9 w-9 shrink-0 items-center justify-center rounded-xl bg-primary/10 text-primary">
                            <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/></svg>
                        </span>
                        <div>
                            <p class="text-xs text-muted-foreground">Назва</p>
                            <p class="mt-0.5 text-sm font-semibold">{{ $institution['name'] }}</p>
                        </div>
                    </div>
                    <div class="flex items-start gap-3">
                        <span class="flex h-9 w-9 shrink-0 items-center justify-center rounded-xl bg-blue-500/10 text-blue-600 dark:text-blue-400">
                            <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                        </span>
                        <div>
                            <p class="text-xs text-muted-foreground">Адреса</p>
                            <p class="mt-0.5 text-sm font-semibold">{{ $institution['address'] }}</p>
                        </div>
                    </div>
                    <div class="flex items-start gap-3">
                        <span class="flex h-9 w-9 shrink-0 items-center justify-center rounded-xl bg-green-500/10 text-green-600 dark:text-green-400">
                            <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/></svg>
                        </span>
                        <div>
                            <p class="text-xs text-muted-foreground">Телефон</p>
                            <a href="tel:{{ preg_replace('/[^0-9+]/', '', $institution['phone']) }}" class="mt-0.5 text-sm font-semibold transition-colors hover:text-primary">{{ $institution['phone'] }}</a>
                        </div>
                    </div>
                    <div class="flex items-start gap-3">
                        <span class="flex h-9 w-9 shrink-0 items-center justify-center rounded-xl bg-purple-500/10 text-purple-600 dark:text-purple-400">
                            <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        </span>
                        <div>
                            <p class="text-xs text-muted-foreground">Години роботи</p>
                            <p class="mt-0.5 text-sm font-semibold">{{ $institution['hours'] }}</p>
                        </div>
                    </div>
                </div>
            </div>
            @endif

            {{-- Pricing & Timeline Card --}}
            <div class="rounded-2xl border border-border bg-card p-6">
                <h3 class="font-semibold">Терміни та вартість</h3>
                <div class="mt-4 space-y-4">
                    <div class="flex items-start gap-3">
                        <span class="flex h-9 w-9 shrink-0 items-center justify-center rounded-xl bg-green-500/10 text-green-600 dark:text-green-400">
                            <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1"/></svg>
                        </span>
                        <div>
                            <p class="text-xs text-muted-foreground">Вартість</p>
                            <p class="mt-0.5 text-sm font-semibold">{{ $service['cost'] }}</p>
                        </div>
                    </div>
                    <div class="flex items-start gap-3">
                        <span class="flex h-9 w-9 shrink-0 items-center justify-center rounded-xl bg-blue-500/10 text-blue-600 dark:text-blue-400">
                            <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        </span>
                        <div>
                            <p class="text-xs text-muted-foreground">Термін</p>
                            <p class="mt-0.5 text-sm font-semibold">{{ $service['timeline'] }}</p>
                        </div>
                    </div>
                    <div class="flex items-start gap-3">
                        <span class="flex h-9 w-9 shrink-0 items-center justify-center rounded-xl bg-purple-500/10 text-purple-600 dark:text-purple-400">
                            <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/></svg>
                        </span>
                        <div>
                            <p class="text-xs text-muted-foreground">Спосіб отримання</p>
                            <p class="mt-0.5 text-sm font-semibold">{{ $service['delivery'] }}</p>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Contact CTA --}}
            <div class="rounded-2xl border border-border bg-secondary/40 p-6">
                <h3 class="font-semibold">Зв'язатися з установою</h3>
                @if($institution)
                <div class="mt-3 space-y-2 text-sm text-muted-foreground">
                    <p class="flex items-center gap-2">
                        <svg class="h-4 w-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/></svg>
                        <a href="tel:{{ preg_replace('/[^0-9+]/', '', $institution['phone']) }}" class="font-semibold transition-colors hover:text-primary">{{ $institution['phone'] }}</a>
                    </p>
                    <p class="flex items-center gap-2">
                        <svg class="h-4 w-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        {{ $institution['hours'] }}
                    </p>
                    @if(!str_starts_with($institution['url'], 'tel:'))
                    <p class="flex items-center gap-2">
                        <svg class="h-4 w-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 01-9 9m9-9a9 9 0 00-9-9m9 9H3m9 9a9 9 0 01-9-9m9 9c1.657 0 3-4.03 3-9s-1.343-9-3-9m0 18c-1.657 0-3-4.03-3-9s1.343-9 3-9m-9 9a9 9 0 019-9"/></svg>
                        <a href="{{ $institution['url'] }}" target="_blank" rel="noopener noreferrer" class="font-semibold transition-colors hover:text-primary">{{ parse_url($institution['url'], PHP_URL_HOST) }}</a>
                    </p>
                    @endif
                </div>
                @endif
                <a href="{{ route('contacts') }}" class="mt-4 flex w-full items-center justify-center gap-2 rounded-full border border-border bg-card px-4 py-2.5 text-sm font-semibold transition-colors hover:bg-secondary/80">
                    Контакти порталу
                </a>
            </div>
        </div>
    </div>

    {{-- Back Link --}}
    <div class="mt-12">
        <a href="{{ route('services') }}" class="inline-flex items-center gap-1.5 text-sm font-semibold text-primary transition-colors hover:underline">
            <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16l-4-4m0 0l4-4m-4 4h18"/></svg>
            Усі послуги
        </a>
    </div>
</div>
@endsection

@section('scripts')
<script>
(function() {
    // FAQ accordion
    document.querySelectorAll('.faq-item').forEach(item => {
        const btn = item.querySelector('.faq-toggle');
        const answer = item.querySelector('.faq-answer');
        btn.addEventListener('click', () => {
            const isOpen = item.classList.contains('open');
            document.querySelectorAll('.faq-item.open').forEach(other => {
                if (other !== item) {
                    other.classList.remove('open');
                    other.querySelector('.faq-answer').style.maxHeight = '0';
                    other.querySelector('.faq-chevron').style.transform = '';
                }
            });
            if (!isOpen) {
                item.classList.add('open');
                answer.style.maxHeight = answer.scrollHeight + 'px';
                btn.querySelector('.faq-chevron').style.transform = 'rotate(180deg)';
            } else {
                item.classList.remove('open');
                answer.style.maxHeight = '0';
                btn.querySelector('.faq-chevron').style.transform = '';
            }
        });
    });
})();
</script>
@endsection
