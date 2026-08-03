@extends('layouts.app')

@section('meta')
    <x-meta
        title="Послуги міста Кропивницький — ЦНАП, довідки, комунальні"
        description="Електронні послуги міста Кропивницький: довідки, реєстрація місця проживання, комунальні платежі, субсидії, звернення до міськради та громадський бюджет."
        image="/images/hero-city.png"
    />
@endsection

@section('pageTitle', 'Послуги міста Кропивницький — ЦНАП, довідки, комунальні')

@section('content')
<section class="border-b border-border bg-secondary/40">
    <div class="mx-auto max-w-6xl px-4 py-12 sm:px-6 sm:py-16">
        <x-breadcrumb :items="[['label' => 'Головна', 'href' => '/'], ['label' => 'Послуги']]" />
        <p class="mt-6 text-sm font-medium text-primary">Електронні послуги</p>
        <h1 class="mt-2 text-balance font-serif text-4xl font-bold tracking-tight sm:text-5xl">Міські послуги онлайн</h1>
        <p class="mt-4 max-w-2xl text-pretty text-lg leading-relaxed text-muted-foreground">Знайдіть потрібну послугу та дізнайтеся, куди звернутися для її отримання. Усі послуги доступні в установах міста.</p>

        <div class="mt-5 flex items-start gap-3 rounded-2xl border border-primary/20 bg-primary/5 p-4 max-w-2xl">
            <span class="flex h-8 w-8 shrink-0 items-center justify-center rounded-lg bg-primary/10 text-primary">
                <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            </span>
            <p class="text-sm text-muted-foreground"><strong class="text-foreground">Всі послуги доступні в установах міста.</strong> Портал надає інформацію — для отримання послуги зверніться безпосередньо до відповідної установи.</p>
        </div>

        {{-- Search --}}
        <div class="mt-8 max-w-xl">
            <div class="relative">
                <svg class="absolute left-3.5 top-1/2 h-5 w-5 -translate-y-1/2 text-muted-foreground" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                <input
                    id="serviceSearch"
                    type="text"
                    placeholder="Пошук послуг..."
                    class="w-full rounded-full border border-border bg-card py-3 pl-11 pr-4 text-sm outline-none transition-colors focus:border-primary focus:ring-2 focus:ring-primary/20"
                />
            </div>
            <p id="searchCount" class="mt-2 text-sm text-muted-foreground"></p>
        </div>
    </div>
</section>

{{-- Category Cards --}}
<section class="mx-auto max-w-6xl px-4 py-10 sm:px-6">
    <div class="grid gap-4 sm:grid-cols-3">
        @foreach($categories as $cat)
            <button
                data-filter="{{ $cat['key'] }}"
                class="category-filter group flex items-start gap-4 rounded-2xl border border-border bg-card p-5 text-left transition-all hover:border-primary/40 hover:shadow-sm"
            >
                <span class="flex h-11 w-11 shrink-0 items-center justify-center rounded-xl bg-primary/10 text-primary">
                    @if($cat['icon'] === 'FileText')
                        <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M14 2H6a2 2 0 00-2 2v16a2 2 0 002 2h12a2 2 0 002-2V8z"/><path d="M14 2v6h6M16 13H8M16 17H8M10 9H8"/></svg>
                    @elseif($cat['icon'] === 'Home')
                        <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M3 9l9-7 9 7v11a2 2 0 01-2 2H5a2 2 0 01-2-2z"/><path d="M9 22V12h6v10"/></svg>
                    @elseif($cat['icon'] === 'Users')
                        <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M17 21v-2a4 4 0 00-4-4H5a4 4 0 00-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 00-3-3.87M16 3.13a4 4 0 010 7.75"/></svg>
                    @endif
                </span>
                <div>
                    <h3 class="font-semibold">{{ $cat['label'] }}</h3>
                    <p class="mt-1 text-sm text-muted-foreground">{{ $cat['description'] }}</p>
                </div>
            </button>
        @endforeach
    </div>
    <button id="clearFilter" class="mt-3 hidden text-sm font-medium text-primary transition-colors hover:underline">Показати всі послуги</button>
</section>

{{-- Service Cards --}}
<section class="mx-auto max-w-6xl px-4 pb-14 sm:px-6">
    <div id="serviceGrid" class="space-y-14">
        @foreach($serviceGroups as $group)
            <div data-category="{{ $group['category'] }}" class="service-group">
                <h2 class="font-serif text-2xl font-bold tracking-tight sm:text-3xl">{{ $group['category'] }}</h2>
                <div class="mt-6 grid gap-5 sm:grid-cols-2 lg:grid-cols-3">
                    @foreach($group['items'] as $item)
                        <a
                            href="{{ route('services.show', $item['slug']) }}"
                            data-title="{{ strtolower($item['title']) }}"
                            data-desc="{{ strtolower($item['description']) }}"
                            class="service-card group flex flex-col rounded-2xl border border-border bg-card p-6 transition-colors hover:border-primary/40"
                        >
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
                            <span class="mt-5 inline-flex items-center gap-1.5 self-start text-sm font-semibold text-primary transition-transform group-hover:translate-x-0.5">
                                {{ $item['action'] }}
                                <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg>
                            </span>
                        </a>
                    @endforeach
                </div>
            </div>
        @endforeach
    </div>

    {{-- No results --}}
    <div id="noResults" class="hidden py-16 text-center">
        <svg class="mx-auto h-12 w-12 text-muted-foreground/50" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
        <p class="mt-4 text-lg font-semibold">Нічого не знайдено</p>
        <p class="mt-1 text-sm text-muted-foreground">Спробуйте інший запит або перегляньте категорії нижче.</p>
    </div>

    <div class="mt-14 flex flex-col items-start gap-4 rounded-3xl border border-border bg-secondary/40 p-8 sm:flex-row sm:items-center sm:justify-between">
        <div>
            <h2 class="font-serif text-2xl font-bold tracking-tight">Не знайшли потрібну послугу?</h2>
            <p class="mt-2 max-w-xl text-sm leading-relaxed text-muted-foreground">Зверніться до Центру надання адміністративних послуг або зателефонуйте на гарячу лінію міста.</p>
        </div>
        <div class="flex flex-col gap-3 sm:flex-row">
            <a href="tel:+3805221580" class="inline-flex shrink-0 items-center justify-center gap-2 rounded-full border border-border bg-card px-6 py-3.5 text-sm font-semibold transition-colors hover:bg-secondary/80">
                <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/></svg>
                1580
            </a>
            <a href="{{ route('contacts') }}" class="inline-flex shrink-0 items-center justify-center gap-2 rounded-full bg-primary px-6 py-3.5 text-sm font-semibold text-primary-foreground transition-transform hover:scale-[1.02]">
                До контактів
                <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg>
            </a>
        </div>
    </div>
</section>

{{-- ЦНАП CTA --}}
<section class="border-y border-border bg-secondary/40">
    <div class="mx-auto max-w-6xl px-4 py-14 sm:px-6 sm:py-16">
        <div class="mx-auto max-w-2xl text-center">
            <span class="inline-flex h-14 w-14 items-center justify-center rounded-2xl bg-primary/10 text-primary">
                <svg class="h-7 w-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/></svg>
            </span>
            <h2 class="mt-4 font-serif text-2xl font-bold tracking-tight sm:text-3xl">Центр надання адміністративних послуг</h2>
            <p class="mt-3 text-muted-foreground">ЦНАП м. Кропивницький — вул. Велика Перспективна, 40. Тут ви можете отримати більшість адміністративних послуг особисто.</p>
            <div class="mt-6 flex flex-col items-center justify-center gap-3 sm:flex-row">
                <a
                    href="tel:+380522334040"
                    class="inline-flex items-center gap-2 rounded-full border border-border bg-card px-6 py-3 text-sm font-semibold transition-colors hover:bg-secondary/80"
                >
                    <svg class="h-4 w-4 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/></svg>
                    (052) 233-40-40
                </a>
                <a
                    href="https://dozvil.kr-rada.gov.ua"
                    target="_blank"
                    rel="noopener noreferrer"
                    class="inline-flex items-center gap-2 rounded-full bg-primary px-6 py-3 text-sm font-semibold text-primary-foreground transition-transform hover:scale-[1.02]"
                >
                    Офіційний сайт ЦНАП
                    <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/></svg>
                </a>
            </div>
            <p class="mt-4 text-xs text-muted-foreground">Пн–Пт: 08:00 – 17:00 &nbsp;·&nbsp; Вул. Велика Перспективна, 40</p>
        </div>
    </div>
</section>

{{-- Map of Service Centers --}}
<section class="mx-auto max-w-6xl px-4 py-14 sm:px-6 sm:py-16">
    <h2 class="font-serif text-2xl font-bold tracking-tight sm:text-3xl">Офіси обслуговування</h2>
    <p class="mt-3 max-w-2xl text-muted-foreground">Знайдіть найближчий ЦНАП або управління для особистого візиту.</p>

    <div class="mt-8 overflow-hidden rounded-2xl border border-border">
        <iframe
            src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d41876.47!2d32.23!3d48.51!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x40d24f1e3f4c4c01%3A0x1!2zNDjCsDMwJzQ5LjQiTiAzMsKwMTQnNDQuMiJF!5e0!3m2!1suk!2sua!4v1721800000000"
            width="100%"
            height="360"
            style="border:0"
            allowfullscreen=""
            loading="lazy"
            referrerpolicy="no-referrer-when-downgrade"
        ></iframe>
    </div>

    <div class="mt-8 grid gap-4 sm:grid-cols-2 lg:grid-cols-4">
        @foreach($offices as $office)
            <div class="rounded-2xl border border-border bg-card p-5">
                <h3 class="font-semibold">{{ $office['name'] }}</h3>
                <div class="mt-3 space-y-2 text-sm text-muted-foreground">
                    <p class="flex items-start gap-2">
                        <svg class="mt-0.5 h-4 w-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                        {{ $office['address'] }}
                    </p>
                    <p class="flex items-start gap-2">
                        <svg class="mt-0.5 h-4 w-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        {{ $office['hours'] }}
                    </p>
                    <p class="flex items-start gap-2">
                        <svg class="mt-0.5 h-4 w-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/></svg>
                        <a href="tel:{{ $office['phone'] }}" class="transition-colors hover:text-primary">{{ $office['phone'] }}</a>
                    </p>
                </div>
            </div>
        @endforeach
    </div>
</section>

@endsection

@section('scripts')
<script>
(function() {
    const search = document.getElementById('serviceSearch');
    const cards = document.querySelectorAll('.service-card');
    const groups = document.querySelectorAll('.service-group');
    const count = document.getElementById('searchCount');
    const noResults = document.getElementById('noResults');
    const catBtns = document.querySelectorAll('.category-filter');
    const clearBtn = document.getElementById('clearFilter');
    let activeFilter = null;

    function filterServices() {
        const q = search.value.toLowerCase().trim();
        let visible = 0;

        groups.forEach(group => {
            const cat = group.dataset.category;
            const items = group.querySelectorAll('.service-card');
            let groupVisible = 0;

            items.forEach(card => {
                const title = card.dataset.title || '';
                const desc = card.dataset.desc || '';
                const matchSearch = !q || title.includes(q) || desc.includes(q);
                const matchCat = !activeFilter || cat === activeFilter;
                const show = matchSearch && matchCat;

                card.style.display = show ? '' : 'none';
                if (show) groupVisible++;
            });

            group.style.display = groupVisible ? '' : 'none';
            visible += groupVisible;
        });

        if (q || activeFilter) {
            count.textContent = `Знайдено: ${visible} ${visible === 1 ? 'послуга' : (visible < 5 ? 'послуги' : 'послуг')}`;
        } else {
            count.textContent = '';
        }

        noResults.classList.toggle('hidden', visible > 0);
    }

    search.addEventListener('input', filterServices);

    catBtns.forEach(btn => {
        btn.addEventListener('click', function() {
            const key = this.dataset.filter;
            const groupIndex = { 'docs': 0, 'housing': 1, 'community': 2 };
            const labels = { 'docs': 'Документи та реєстрація', 'housing': 'Житло та комунальні', 'community': 'Громада та звернення' };

            if (activeFilter === labels[key]) {
                activeFilter = null;
                catBtns.forEach(b => b.classList.remove('border-primary', 'bg-primary/5'));
                clearBtn.classList.add('hidden');
            } else {
                activeFilter = labels[key];
                catBtns.forEach(b => b.classList.remove('border-primary', 'bg-primary/5'));
                this.classList.add('border-primary', 'bg-primary/5');
                clearBtn.classList.remove('hidden');
            }
            filterServices();
        });
    });

    clearBtn.addEventListener('click', function() {
        activeFilter = null;
        search.value = '';
        catBtns.forEach(b => b.classList.remove('border-primary', 'bg-primary/5'));
        this.classList.add('hidden');
        filterServices();
    });

})();
</script>
@endsection
