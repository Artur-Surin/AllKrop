<!DOCTYPE html>
<html lang="uk" data-theme="light">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="theme-color" content="#0b1b3f">
    @yield('meta')
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Manrope:wght@400;500;600;700;800&family=Playfair+Display:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        :root {
            --font-sans: 'Manrope', sans-serif;
            --font-serif: 'Playfair Display', serif;
        }
        body { font-family: var(--font-sans); }
        .font-serif { font-family: var(--font-serif); }
    </style>
    <script>
        (function() {
            try {
                var t = localStorage.getItem('kr-theme') || 'light';
                document.documentElement.setAttribute('data-theme', t);
            } catch (e) {
                document.documentElement.setAttribute('data-theme', 'light');
            }
        })();
    </script>
</head>
<body class="min-h-screen bg-background text-foreground antialiased">

    <a href="#main-content" class="sr-only focus:not-sr-only focus:absolute focus:z-[100] focus:p-4 focus:bg-primary focus:text-primary-foreground">Перейти до вмісту</a>

    @php
        $navLinks = App\Services\ContentService::navLinks();
    @endphp

    <header id="site-header" class="sticky top-0 z-50 border-b border-transparent transition-colors duration-300">
        <div class="mx-auto flex h-16 max-w-6xl items-center justify-between gap-4 px-4 sm:px-6">
            <a href="/" class="flex items-center gap-2.5">
                <span class="flex h-9 w-9 items-center justify-center rounded-xl bg-primary font-serif text-lg font-bold text-primary-foreground">К</span>
                <span class="hidden flex-col leading-none sm:flex">
                    <span class="text-sm font-semibold tracking-tight text-foreground">Кропивницький</span>
                    <span class="text-[11px] text-muted-foreground">міський портал</span>
                </span>
            </a>

            <nav class="hidden items-center gap-1 md:flex" aria-label="Головне меню">
                @php
                    $categories = App\Services\ContentService::enterpriseCategories();
                @endphp
                @foreach($navLinks as $link)
                    @if($link['href'] === '/places')
                        <div class="group relative">
                            <a href="/places" class="flex items-center gap-1 rounded-full px-3.5 py-2 text-sm font-medium text-muted-foreground transition-colors hover:bg-secondary hover:text-foreground">
                                {{ $link['label'] }}
                                <svg class="h-3.5 w-3.5 transition-transform group-hover:rotate-180" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                            </a>
                            <div class="invisible absolute left-1/2 top-full z-50 w-[520px] -translate-x-1/2 pt-3 opacity-0 transition-all duration-200 group-hover:visible group-hover:opacity-100">
                                <div class="overflow-hidden rounded-2xl border border-border bg-background/95 p-2 shadow-xl backdrop-blur-xl">
                                    <div class="grid grid-cols-2 gap-1">
                                        @foreach($categories as $cat)
                                            <a href="/places/category/{{ $cat['key'] }}" class="flex items-start gap-3 rounded-xl p-3 transition-colors hover:bg-secondary">
                                                <span class="flex h-9 w-9 shrink-0 items-center justify-center rounded-lg bg-primary/10 text-primary">
                                                    @switch($cat['icon'])
                                                        @case('UtensilsCrossed')
                                                            <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M3 2v7c0 1.1.9 2 2 2h4a2 2 0 002-2V2M7 2v20M21 15V2v0a5 5 0 00-5 5v6c0 1.1.9 2 2 2h3zm0 0v7"/></svg>
                                                            @break
                                                        @case('ShoppingBag')
                                                            <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M6 2L3 6v14a2 2 0 002 2h14a2 2 0 002-2V6l-3-4zM3 6h18M16 10a4 4 0 01-8 0"/></svg>
                                                            @break
                                                        @case('Drama')
                                                            <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zM8 14s1.5 2 4 2 4-2 4-2M9 9h.01M15 9h.01"/></svg>
                                                            @break
                                                        @case('HeartPulse')
                                                            <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M19.5 12.572l-7.5 7.428-7.5-7.428A5 5 0 1112 6.006a5 5 0 017.5 6.572M12 6v6l3-3"/></svg>
                                                            @break
                                                        @case('GraduationCap')
                                                            <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M12 3L1 9l4 2.18v6L12 21l7-3.82v-6l2-1.09V17h2V9L12 3zm6.82 6L12 12.72 5.18 9 12 5.28 18.82 9zM17 15.99l-5 2.73-5-2.73v-3.68L12 15l5-2.73v3.68z"/></svg>
                                                            @break
                                                        @case('Car')
                                                            <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M14 16H9m10 0h3v-3.15a1 1 0 00-.84-.99L16 11l-2.7-6.06A1 1 0 0012.38 4H5.62a1 1 0 00-.92.61L2 11l-1.16.85A1 1 0 000 12.85V16h3m10 0a2 2 0 11-4 0m4 0a2 2 0 10-4 0m-6 0a2 2 0 11-4 0m4 0a2 2 0 10-4 0"/></svg>
                                                            @break
                                                        @case('Briefcase')
                                                            <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M22 19a2 2 0 01-2 2H4a2 2 0 01-2-2V5a2 2 0 012-2h5l2 3h9a2 2 0 012 2z"/></svg>
                                                            @break
                                                        @case('Factory')
                                                            <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M2 20h20M5 20V8l5 4V8l5 4V4h3v16"/></svg>
                                                            @break
                                                        @default
                                                            <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/></svg>
                                                    @endswitch
                                                </span>
                                                <span class="flex flex-col">
                                                    <span class="text-sm font-medium text-foreground">{{ $cat['label'] }}</span>
                                                    <span class="line-clamp-1 text-xs text-muted-foreground">{{ $cat['description'] }}</span>
                                                </span>
                                            </a>
                                        @endforeach
                                    </div>
                                    <a href="/places" class="mt-1 flex items-center justify-center rounded-xl bg-secondary px-4 py-2.5 text-sm font-medium text-foreground transition-colors hover:bg-primary hover:text-primary-foreground">
                                        Усі підприємства міста
                                    </a>
                                </div>
                            </div>
                        </div>
                    @else
                        <a href="{{ $link['href'] }}" class="rounded-full px-3.5 py-2 text-sm font-medium text-muted-foreground transition-colors hover:bg-secondary hover:text-foreground">{{ $link['label'] }}</a>
                    @endif
                @endforeach
            </nav>

            <div class="flex items-center gap-2">
                <a href="/search" aria-label="Пошук" class="flex h-9 w-9 items-center justify-center rounded-lg text-muted-foreground transition-colors hover:bg-secondary hover:text-foreground">
                    <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><circle cx="11" cy="11" r="8"/><path d="M21 21l-4.35-4.35"/></svg>
                </a>
                <div role="radiogroup" aria-label="Вибір теми оформлення" class="flex items-center gap-1 rounded-full border border-border bg-secondary/60 p-1 backdrop-blur">
                    <button role="radio" aria-checked="true" data-theme-btn="light" class="theme-btn flex h-8 w-8 items-center justify-center rounded-full transition-colors sm:w-auto sm:gap-1.5 sm:px-3 bg-primary text-primary-foreground">
                        <svg class="h-4 w-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><circle cx="12" cy="12" r="5"/><path d="M12 1v2M12 21v2M4.22 4.22l1.42 1.42M18.36 18.36l1.42 1.42M1 12h2M21 12h2M4.22 19.78l1.42-1.42M18.36 5.64l1.42-1.42"/></svg>
                        <span class="hidden text-xs font-medium sm:inline">Світла</span>
                    </button>
                    <button role="radio" aria-checked="false" data-theme-btn="dark" class="theme-btn flex h-8 w-8 items-center justify-center rounded-full transition-colors sm:w-auto sm:gap-1.5 sm:px-3 text-muted-foreground hover:text-foreground">
                        <svg class="h-4 w-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M21 12.79A9 9 0 1 1 11.21 3 7 7 0 0 0 21 12.79z"/></svg>
                        <span class="hidden text-xs font-medium sm:inline">Темна</span>
                    </button>
                    <button role="radio" aria-checked="false" data-theme-btn="contrast" class="theme-btn flex h-8 w-8 items-center justify-center rounded-full transition-colors sm:w-auto sm:gap-1.5 sm:px-3 text-muted-foreground hover:text-foreground">
                        <svg class="h-4 w-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z"/></svg>
                        <span class="hidden text-xs font-medium sm:inline">Контраст</span>
                    </button>
                </div>
                <button id="mobile-menu-btn" class="flex h-9 w-9 items-center justify-center rounded-lg border border-border text-foreground md:hidden" aria-label="Меню">
                    <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/></svg>
                </button>
            </div>
        </div>

        <nav id="mobile-menu" class="hidden border-t border-border bg-background/95 px-4 py-3 backdrop-blur-xl md:hidden">
            @foreach($navLinks as $link)
                <a href="{{ $link['href'] }}" class="block rounded-lg px-3 py-2.5 text-sm font-medium text-foreground hover:bg-secondary">{{ $link['label'] }}</a>
            @endforeach
        </nav>
    </header>

    <main id="main-content">
        @yield('content')
    </main>

    <footer class="border-t border-border bg-background">
        <div class="mx-auto max-w-6xl px-4 sm:px-6">
            <div class="grid gap-10 border-b border-border py-16 lg:grid-cols-[1.2fr_1fr]">
                <div>
                    <h2 class="text-balance font-serif text-3xl font-bold tracking-tight sm:text-4xl">Будьте в курсі життя міста</h2>
                    <p class="mt-3 max-w-md text-pretty leading-relaxed text-muted-foreground">Щотижнева розсилка з головними новинами, анонсами подій та рекомендаціями закладів.</p>
                    <form class="mt-6 flex max-w-md flex-col gap-3 sm:flex-row">
                        <div class="relative flex-1">
                            <svg class="pointer-events-none absolute left-3.5 top-1/2 h-4 w-4 -translate-y-1/2 text-muted-foreground" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"/><path d="M22 6l-10 7L2 6"/></svg>
                            <input type="email" required placeholder="Ваша електронна пошта" class="h-12 w-full rounded-full border border-border bg-card pl-10 pr-4 text-sm outline-none transition-colors focus:border-primary">
                        </div>
                        <button type="submit" class="inline-flex h-12 items-center justify-center gap-2 rounded-full bg-primary px-6 text-sm font-semibold text-primary-foreground transition-transform hover:scale-[1.02]">
                            Підписатися
                            <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M22 2L11 13M22 2l-7 20-4-9-9-4 20-7z"/></svg>
                        </button>
                    </form>
                </div>

                <div class="grid grid-cols-2 gap-8 lg:justify-items-end">
                    <div>
                        <p class="text-sm font-semibold">Розділи</p>
                        <ul class="mt-4 space-y-3 text-sm text-muted-foreground">
                            @foreach($navLinks as $link)
                                <li><a href="{{ $link['href'] }}" class="transition-colors hover:text-foreground">{{ $link['label'] }}</a></li>
                            @endforeach
                        </ul>
                    </div>
                    <div>
                        <p class="text-sm font-semibold">Місто</p>
                        <ul class="mt-4 space-y-3 text-sm text-muted-foreground">
                            <li><a href="/city" class="transition-colors hover:text-foreground">Про Кропивницький</a></li>
                            <li><a href="/contacts" class="transition-colors hover:text-foreground">Контакти</a></li>
                            <li><a href="/news" class="transition-colors hover:text-foreground">Новини</a></li>
                            <li><a href="/events" class="transition-colors hover:text-foreground">Афіша</a></li>
                        </ul>
                    </div>
                </div>
            </div>

            <div class="flex flex-col items-center justify-between gap-4 py-8 sm:flex-row">
                <div class="flex items-center gap-2.5">
                    <span class="flex h-8 w-8 items-center justify-center rounded-lg bg-primary font-serif text-sm font-bold text-primary-foreground">К</span>
                    <span class="text-sm font-medium">Кропивницький · міський портал</span>
                </div>
                <p class="text-xs text-muted-foreground">&copy; {{ date('Y') }} Усі права захищено</p>
            </div>
        </div>
    </footer>

    <script>
        const themeBtns = document.querySelectorAll('[data-theme-btn]');
        function applyTheme(t) {
            document.documentElement.setAttribute('data-theme', t);
            localStorage.setItem('kr-theme', t);
            themeBtns.forEach(btn => {
                const isActive = btn.getAttribute('data-theme-btn') === t;
                btn.setAttribute('aria-checked', isActive);
                if (isActive) {
                    btn.classList.add('bg-primary', 'text-primary-foreground');
                    btn.classList.remove('text-muted-foreground');
                } else {
                    btn.classList.remove('bg-primary', 'text-primary-foreground');
                    btn.classList.add('text-muted-foreground');
                }
            });
        }
        themeBtns.forEach(btn => {
            btn.addEventListener('click', () => applyTheme(btn.getAttribute('data-theme-btn')));
        });
        applyTheme(localStorage.getItem('kr-theme') || 'light');

        const header = document.getElementById('site-header');
        window.addEventListener('scroll', () => {
            if (window.scrollY > 12) {
                header.classList.add('border-border', 'bg-background/80', 'backdrop-blur-xl');
                header.classList.remove('border-transparent', 'bg-transparent');
            } else {
                header.classList.remove('border-border', 'bg-background/80', 'backdrop-blur-xl');
                header.classList.add('border-transparent', 'bg-transparent');
            }
        }, { passive: true });
        window.dispatchEvent(new Event('scroll'));

        const mobileBtn = document.getElementById('mobile-menu-btn');
        const mobileMenu = document.getElementById('mobile-menu');
        mobileBtn.addEventListener('click', () => {
            mobileMenu.classList.toggle('hidden');
        });
    </script>

    @yield('scripts')
</body>
</html>
