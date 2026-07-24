@extends('layouts.app')

@section('meta')
    <x-meta title="Контакти — Кропивницький" description="Зв'яжіться з редакцією міського порталу" />
@endsection

@section('pageTitle', 'Контакти — Кропивницький')
@section('pageDescription', 'Зв\u2019яжіться з редакцією міського порталу Кропивницький.')

@section('content')
<section class="border-b border-border bg-secondary/40">
    <div class="mx-auto max-w-6xl px-4 py-12 sm:px-6 sm:py-16">
        <nav aria-label="Хлібні крихти" class="flex items-center gap-1.5 text-sm text-muted-foreground">
            <span class="flex items-center gap-1.5">
                <a href="/" class="transition-colors hover:text-foreground">Головна</a>
            </span>
            <span class="flex items-center gap-1.5">
                <svg class="h-3.5 w-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                <span class="text-foreground">Контакти</span>
            </span>
        </nav>
        <p class="mt-6 text-sm font-medium text-primary">Контакти</p>
        <h1 class="mt-2 text-balance font-serif text-4xl font-bold tracking-tight sm:text-5xl">Зв'яжіться з нами</h1>
        <p class="mt-4 max-w-2xl text-pretty text-lg leading-relaxed text-muted-foreground">Маєте новину, пропозицію чи хочете додати заклад до довідника? Напишіть редакції міського порталу.</p>
    </div>
</section>

<div class="mx-auto max-w-6xl px-4 py-14 sm:px-6 sm:py-16">
    <div class="grid gap-10 lg:grid-cols-[1fr_1.3fr]">
        <div class="space-y-4">
            <div class="flex items-start gap-4 rounded-2xl border border-border bg-card p-5">
                <span class="flex h-11 w-11 shrink-0 items-center justify-center rounded-xl bg-secondary text-primary">
                    <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                </span>
                <div>
                    <p class="text-xs text-muted-foreground">Адреса</p>
                    <p class="mt-0.5 text-sm font-medium">вул. Велика Перспективна, 41, Кропивницький</p>
                </div>
            </div>
            <div class="flex items-start gap-4 rounded-2xl border border-border bg-card p-5">
                <span class="flex h-11 w-11 shrink-0 items-center justify-center rounded-xl bg-secondary text-primary">
                    <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M22 16.92v3a2 2 0 01-2.18 2 19.79 19.79 0 01-8.63-3.07 19.5 19.5 0 01-6-6 19.79 19.79 0 01-3.07-8.67A2 2 0 014.11 2h3a2 2 0 012 1.72c.127.96.361 1.903.7 2.81a2 2 0 01-.45 2.11L8.09 9.91a16 16 0 006 6l1.27-1.27a2 2 0 012.11-.45c.907.339 1.85.573 2.81.7A2 2 0 0122 16.92z"/></svg>
                </span>
                <div>
                    <p class="text-xs text-muted-foreground">Телефон</p>
                    <p class="mt-0.5 text-sm font-medium">+380 (52) 000 00 00</p>
                </div>
            </div>
            <div class="flex items-start gap-4 rounded-2xl border border-border bg-card p-5">
                <span class="flex h-11 w-11 shrink-0 items-center justify-center rounded-xl bg-secondary text-primary">
                    <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"/><path d="M22 6l-10 7L2 6"/></svg>
                </span>
                <div>
                    <p class="text-xs text-muted-foreground">Пошта</p>
                    <p class="mt-0.5 text-sm font-medium">hello@kropyvnytskyi.city</p>
                </div>
            </div>
            <div class="flex items-start gap-4 rounded-2xl border border-border bg-card p-5">
                <span class="flex h-11 w-11 shrink-0 items-center justify-center rounded-xl bg-secondary text-primary">
                    <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><path d="M12 6v6l4 2"/></svg>
                </span>
                <div>
                    <p class="text-xs text-muted-foreground">Графік</p>
                    <p class="mt-0.5 text-sm font-medium">Пн–Пт, 09:00 – 18:00</p>
                </div>
            </div>
        </div>

        <div>
            <div id="contact-success" class="hidden flex-col items-center justify-center rounded-2xl border border-border bg-card p-10 text-center">
                <span class="flex h-14 w-14 items-center justify-center rounded-full bg-primary text-primary-foreground">
                    <svg class="h-7 w-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                </span>
                <h2 class="mt-5 font-serif text-2xl font-bold">Дякуємо за звернення!</h2>
                <p class="mt-2 max-w-sm text-pretty text-muted-foreground">Ми отримали ваше повідомлення та відповімо найближчим часом.</p>
                <button onclick="document.getElementById('contact-success').classList.add('hidden');document.getElementById('contact-success').classList.remove('flex');document.getElementById('contact-form').classList.remove('hidden');" class="mt-6 rounded-full border border-border px-5 py-2.5 text-sm font-medium transition-colors hover:bg-secondary">Надіслати ще одне</button>
            </div>
            <form id="contact-form" class="rounded-2xl border border-border bg-card p-6 sm:p-8">
                <div class="grid gap-5 sm:grid-cols-2">
                    <div>
                        <label for="name" class="text-sm font-medium">Ім'я</label>
                        <input type="text" id="name" required placeholder="Ваше ім'я" class="mt-2 h-12 w-full rounded-xl border border-border bg-card px-4 text-sm outline-none transition-colors focus:border-primary">
                    </div>
                    <div>
                        <label for="email" class="text-sm font-medium">Пошта</label>
                        <input type="email" id="email" required placeholder="you@example.com" class="mt-2 h-12 w-full rounded-xl border border-border bg-card px-4 text-sm outline-none transition-colors focus:border-primary">
                    </div>
                </div>
                <div class="mt-5">
                    <label for="subject" class="text-sm font-medium">Тема</label>
                    <input type="text" id="subject" required placeholder="Коротко про що йдеться" class="mt-2 h-12 w-full rounded-xl border border-border bg-card px-4 text-sm outline-none transition-colors focus:border-primary">
                </div>
                <div class="mt-5">
                    <label for="message" class="text-sm font-medium">Повідомлення</label>
                    <textarea id="message" rows="5" required placeholder="Ваше повідомлення…" class="mt-2 w-full rounded-xl border border-border bg-card px-4 py-3 text-sm outline-none transition-colors focus:border-primary"></textarea>
                </div>
                <button type="submit" class="mt-6 inline-flex items-center justify-center gap-2 rounded-full bg-primary px-6 py-3 text-sm font-semibold text-primary-foreground transition-transform hover:scale-[1.02]">
                    Надіслати повідомлення
                    <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M22 2L11 13M22 2l-7 20-4-9-9-4 20-7z"/></svg>
                </button>
            </form>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    document.getElementById('contact-form').addEventListener('submit', function(e) {
        e.preventDefault();
        this.classList.add('hidden');
        const success = document.getElementById('contact-success');
        success.classList.remove('hidden');
        success.classList.add('flex');
    });
</script>
@endsection
