@extends('layouts.app')

@section('meta')
    <x-meta title="Контакти — All Kropyvnytskiy" description="Зв'яжіться з редакцією міського порталу Кропивницького. Пропозиції новин, розміщення реклами та співпраця." image="/images/hero-city.png" />
    
    {{-- Schema.org JSON-LD Microdata --}}
    <script type="application/ld+json">
    {
        "@context": "https://schema.org",
        "@type": "NewsMediaOrganization",
        "name": "All Kropyvnytskiy",
        "url": "{{ config('app.url') }}",
        "logo": "{{ config('app.url') }}/images/hero-city.png",
        "sameAs": [],
        "address": {
            "@type": "PostalAddress",
            "streetAddress": "вул. Велика Перспективна, 41",
            "addressLocality": "Кропивницький",
            "addressRegion": "Кіровоградська область",
            "postalCode": "25000",
            "addressCountry": "UA"
        },
        "contactPoint": {
            "@type": "ContactPoint",
            "telephone": "+380520000000",
            "contactType": "customer service",
            "email": "hello@kropyvnytskyi.city",
            "availableLanguage": ["Ukrainian"]
        }
    }
    </script>
@endsection

@section('pageTitle', 'Контакти — Кропивницький')
@section('pageDescription', 'Зв’яжіться з редакцією міського порталу Кропивницький.')

@section('content')
<section class="border-b border-border bg-secondary/40">
    <div class="mx-auto max-w-6xl px-4 py-12 sm:px-6 sm:py-16">
        <x-breadcrumb :items="[['label' => 'Головна', 'href' => '/'], ['label' => 'Контакти']]" />
        <p class="mt-6 text-sm font-medium text-primary">Зворотний зв'язок</p>
        <h1 class="mt-2 text-balance font-serif text-4xl font-bold tracking-tight sm:text-5xl">Зв'яжіться з нами</h1>
        <p class="mt-4 max-w-2xl text-pretty text-lg leading-relaxed text-muted-foreground">
            Маєте новину, пропозицію щодо співпраці чи хочете додати бізнес до довідника Кропивницького? Напишіть нашій редакції.
        </p>
    </div>
</section>

<div class="mx-auto max-w-6xl px-4 py-14 sm:px-6 sm:py-16">
    <div class="grid gap-10 lg:grid-cols-[1fr_1.3fr]">
        {{-- Contact Info Cards --}}
        <div class="space-y-4">
            <div class="flex items-start gap-4 rounded-2xl border border-border bg-card p-5 transition-shadow hover:shadow-sm">
                <span class="flex h-11 w-11 shrink-0 items-center justify-center rounded-xl bg-secondary text-primary">
                    <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                </span>
                <div>
                    <p class="text-xs font-medium text-muted-foreground uppercase tracking-wider">Адреса редакції</p>
                    <p class="mt-0.5 text-sm font-semibold">вул. Велика Перспективна, 41, Кропивницький</p>
                </div>
            </div>

            <div class="flex items-start gap-4 rounded-2xl border border-border bg-card p-5 transition-shadow hover:shadow-sm">
                <span class="flex h-11 w-11 shrink-0 items-center justify-center rounded-xl bg-secondary text-primary">
                    <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M22 16.92v3a2 2 0 01-2.18 2 19.79 19.79 0 01-8.63-3.07 19.5 19.5 0 01-6-6 19.79 19.79 0 01-3.07-8.67A2 2 0 014.11 2h3a2 2 0 012 1.72c.127.96.361 1.903.7 2.81a2 2 0 01-.45 2.11L8.09 9.91a16 16 0 006 6l1.27-1.27a2 2 0 012.11-.45c.907.339 1.85.573 2.81.7A2 2 0 0122 16.92z"/></svg>
                </span>
                <div>
                    <p class="text-xs font-medium text-muted-foreground uppercase tracking-wider">Телефон</p>
                    <p class="mt-0.5 text-sm font-semibold">+380 (52) 000 00 00</p>
                </div>
            </div>

            <div class="flex items-start gap-4 rounded-2xl border border-border bg-card p-5 transition-shadow hover:shadow-sm">
                <span class="flex h-11 w-11 shrink-0 items-center justify-center rounded-xl bg-secondary text-primary">
                    <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"/><path d="M22 6l-10 7L2 6"/></svg>
                </span>
                <div>
                    <p class="text-xs font-medium text-muted-foreground uppercase tracking-wider">Електронна пошта</p>
                    <p class="mt-0.5 text-sm font-semibold">
                        <a href="mailto:hello@kropyvnytskyi.city" class="text-primary hover:underline">hello@kropyvnytskyi.city</a>
                    </p>
                </div>
            </div>

            <div class="flex items-start gap-4 rounded-2xl border border-border bg-card p-5 transition-shadow hover:shadow-sm">
                <span class="flex h-11 w-11 shrink-0 items-center justify-center rounded-xl bg-secondary text-primary">
                    <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><path d="M12 6v6l4 2"/></svg>
                </span>
                <div>
                    <p class="text-xs font-medium text-muted-foreground uppercase tracking-wider">Графік роботи</p>
                    <p class="mt-0.5 text-sm font-semibold">Пн–Пт, 09:00 – 18:00</p>
                </div>
            </div>

            {{-- Special Advertisers Box --}}
            <div class="mt-6 rounded-2xl border border-primary/20 bg-primary/5 p-6">
                <div class="flex items-center gap-3 text-primary font-semibold">
                    <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5.882V19.24a1.76 1.76 0 01-3.417.592l-2.147-6.15M18 13a3 3 0 100-6M5.436 13.683A4.001 4.001 0 017 6h1.832c4.1 0 7.625-1.234 9.168-3v14c-1.543-1.766-5.067-3-9.168-3H7a3.988 3.988 0 01-1.564-.317z"/></svg>
                    <span>Рекламодавцям та бізнесу</span>
                </div>
                <p class="mt-2 text-xs leading-relaxed text-muted-foreground">
                    Бажаєте розмістити баннерну рекламу, партнерську статтю або додати ваш заклад до ТОП-каталогу Кропивницького? Оберіть тему «Реклама та співпраця» у формі.
                </p>
            </div>
        </div>

        {{-- Livewire Contact Form --}}
        <div>
            <livewire:contact-form />
        </div>
    </div>
</div>
@endsection
