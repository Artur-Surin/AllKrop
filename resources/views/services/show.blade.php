@extends('layouts.app')

@section('meta')
    <x-meta title="{{ $service['title'] }} — Послуги — Кропивницький" description="{{ $service['description'] }}" />
@endsection

@section('pageTitle', $service['title'] . ' — Послуги')
@section('pageDescription', $service['description'])

@section('content')
<section class="border-b border-border bg-secondary/40">
    <div class="mx-auto max-w-6xl px-4 py-12 sm:px-6 sm:py-16">
        <nav aria-label="Хлібні крихти" class="flex items-center gap-1.5 text-sm text-muted-foreground">
            <a href="/" class="transition-colors hover:text-foreground">Головна</a>
            <svg class="h-3.5 w-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
            <a href="{{ route('services') }}" class="transition-colors hover:text-foreground">Послуги</a>
            <svg class="h-3.5 w-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
            <span class="text-foreground">{{ $service['title'] }}</span>
        </nav>

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

            {{-- Steps --}}
            @if(!empty($service['steps']))
            <div class="rounded-2xl border border-border bg-card p-6">
                <h2 class="flex items-center gap-2 font-serif text-xl font-bold tracking-tight">
                    <svg class="h-5 w-5 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/></svg>
                    Покрокова інструкція
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
            @if(!empty($service['documents']))
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

                <button
                    id="openFormBtn"
                    class="mt-6 flex w-full items-center justify-center gap-2 rounded-full bg-primary px-5 py-3 text-sm font-semibold text-primary-foreground transition-transform hover:scale-[1.02]"
                >
                    Замовити послугу
                    <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg>
                </button>
            </div>

            {{-- Nearby Offices --}}
            <div class="rounded-2xl border border-border bg-card p-6">
                <h3 class="font-semibold">Найближчі офіси</h3>
                <div class="mt-4 space-y-3">
                    @foreach(array_slice($offices, 0, 2) as $office)
                        <div class="rounded-xl bg-secondary/50 p-3">
                            <p class="text-sm font-medium">{{ $office['name'] }}</p>
                            <p class="mt-1 text-xs text-muted-foreground">{{ $office['address'] }}</p>
                            <p class="mt-0.5 text-xs text-muted-foreground">{{ $office['hours'] }}</p>
                        </div>
                    @endforeach
                </div>
            </div>

            {{-- Help CTA --}}
            <div class="rounded-2xl border border-border bg-secondary/40 p-6">
                <h3 class="font-semibold">Потрібна допомога?</h3>
                <p class="mt-2 text-sm text-muted-foreground">Зателефонуйте на гарячу лінію або напишіть нам.</p>
                <a href="{{ route('contacts') }}" class="mt-4 flex w-full items-center justify-center gap-2 rounded-full border border-border bg-card px-4 py-2.5 text-sm font-semibold transition-colors hover:bg-secondary/80">
                    Контакти
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

{{-- Service Request Modal --}}
<div id="serviceModal" class="fixed inset-0 z-50 hidden items-center justify-center bg-black/50 backdrop-blur-sm">
    <div class="mx-4 w-full max-w-lg rounded-2xl border border-border bg-card p-6 shadow-xl">
        <div class="flex items-center justify-between">
            <h3 class="font-serif text-xl font-bold">Замовити послугу</h3>
            <button id="closeModal" class="rounded-lg p-1 text-muted-foreground transition-colors hover:bg-secondary hover:text-foreground">
                <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
            </button>
        </div>
        <p class="mt-2 text-sm text-muted-foreground">Заповніть форму для «{{ $service['title'] }}»</p>

        <form id="serviceForm" class="mt-6 space-y-4">
            <div>
                <label class="text-sm font-medium">Ім'я</label>
                <input type="text" name="name" required class="mt-1.5 w-full rounded-xl border border-border bg-secondary/50 px-4 py-2.5 text-sm outline-none transition-colors focus:border-primary focus:ring-2 focus:ring-primary/20" placeholder="Ваше ім'я" />
            </div>
            <div>
                <label class="text-sm font-medium">Телефон</label>
                <input type="tel" name="phone" required class="mt-1.5 w-full rounded-xl border border-border bg-secondary/50 px-4 py-2.5 text-sm outline-none transition-colors focus:border-primary focus:ring-2 focus:ring-primary/20" placeholder="+38 (0XX) XXX-XX-XX" />
            </div>
            <div>
                <label class="text-sm font-medium">Електронна пошта</label>
                <input type="email" name="email" class="mt-1.5 w-full rounded-xl border border-border bg-secondary/50 px-4 py-2.5 text-sm outline-none transition-colors focus:border-primary focus:ring-2 focus:ring-primary/20" placeholder="email@example.com" />
            </div>
            <div>
                <label class="text-sm font-medium">Коментар</label>
                <textarea name="comment" rows="3" class="mt-1.5 w-full resize-none rounded-xl border border-border bg-secondary/50 px-4 py-2.5 text-sm outline-none transition-colors focus:border-primary focus:ring-2 focus:ring-primary/20" placeholder="Опишіть вашу потребу..."></textarea>
            </div>
            <button type="submit" class="flex w-full items-center justify-center gap-2 rounded-full bg-primary px-5 py-3 text-sm font-semibold text-primary-foreground transition-transform hover:scale-[1.02]">
                Надіслати заявку
                <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"/></svg>
            </button>
        </form>

        <div id="formSuccess" class="hidden py-8 text-center">
            <div class="mx-auto flex h-14 w-14 items-center justify-center rounded-full bg-green-500/10 text-green-600 dark:text-green-400">
                <svg class="h-7 w-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
            </div>
            <p class="mt-4 text-lg font-bold">Заявку надіслано!</p>
            <p class="mt-2 text-sm text-muted-foreground">Ми зв'яжемося з вами протягом 1–2 робочих днів.</p>
            <p class="mt-1 text-xs text-muted-foreground">Номер вашої заявки: <strong id="modalTrackingNum"></strong></p>
        </div>
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

    // Modal
    const modal = document.getElementById('serviceModal');
    const openBtn = document.getElementById('openFormBtn');
    const closeBtn = document.getElementById('closeModal');
    const form = document.getElementById('serviceForm');
    const success = document.getElementById('formSuccess');
    const trackNum = document.getElementById('modalTrackingNum');

    openBtn.addEventListener('click', () => {
        modal.classList.remove('hidden');
        modal.classList.add('flex');
        document.body.style.overflow = 'hidden';
    });

    closeBtn.addEventListener('click', closeModal);
    modal.addEventListener('click', (e) => { if (e.target === modal) closeModal(); });

    function closeModal() {
        modal.classList.add('hidden');
        modal.classList.remove('flex');
        document.body.style.overflow = '';
    }

    form.addEventListener('submit', (e) => {
        e.preventDefault();
        const num = 'ZAY-' + new Date().getFullYear() + '-' + String(Math.floor(Math.random() * 999999)).padStart(6, '0');
        trackNum.textContent = num;
        form.classList.add('hidden');
        success.classList.remove('hidden');
    });

    document.addEventListener('keydown', (e) => {
        if (e.key === 'Escape' && !modal.classList.contains('hidden')) closeModal();
    });
})();
</script>
@endsection
