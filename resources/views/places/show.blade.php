@extends('layouts.app')

@php
    $category = $place->category;
    $reviews = $place->reviews()->get();
    $avgRating = $place->average_rating;
    $reviewsCount = $place->reviews_count;
@endphp

@section('meta')
    <x-meta title="{{ $place->name }} — Кропивницький" description="{{ $place->description[0] ?? $place->name }}" image="{{ $place->image }}" />
@endsection

@section('json-ld')
@php
    $schemas = [
        [
            '@context' => 'https://schema.org',
            '@type' => 'LocalBusiness',
            'name' => $place->name,
            'address' => [
                '@type' => 'PostalAddress',
                'streetAddress' => $place->address,
                'addressLocality' => 'Кропивницький',
                'addressCountry' => 'UA',
            ],
            'telephone' => $place->phone,
            'openingHours' => $place->hours,
            'image' => $place->image ? asset($place->image) : null,
        ],
    ];
    if ($reviewsCount > 0) {
        $schemas[0]['aggregateRating'] = [
            '@type' => 'AggregateRating',
            'ratingValue' => $avgRating,
            'reviewCount' => $reviewsCount,
            'bestRating' => 5,
            'worstRating' => 1,
        ];
    }
@endphp
<x-json-ld :schemas="$schemas" />
@endsection

@section('pageTitle', $place->name . ' — Кропивницький')
@section('pageDescription', $place->description[0] ?? $place->name)

@section('content')
<div class="mx-auto max-w-6xl px-4 py-12 sm:px-6 sm:py-16">
    <x-breadcrumb :items="[
        ['label' => 'Головна', 'href' => '/'],
        ['label' => 'Каталог', 'href' => route('places.index')],
        $category ? ['label' => $category->label, 'href' => route('places.category', $category->key)] : null,
        ['label' => $place->name],
    ]" />

    <div class="mt-8 grid gap-10 lg:grid-cols-[1.5fr_1fr]">
        <div>
            <div class="overflow-hidden rounded-3xl border border-border">
                <img src="{{ $place->image }}" alt="{{ $place->name }}" class="aspect-[16/10] w-full object-cover" loading="lazy" decoding="async">
            </div>
            <p class="mt-6 text-sm font-medium text-primary">{{ $place->category->label ?? '' }}</p>
            <h1 class="mt-2 text-balance font-serif text-3xl font-bold tracking-tight sm:text-4xl">{{ $place->name }}</h1>
            <div class="mt-3 flex items-center gap-4 text-sm text-muted-foreground">
                <span class="flex items-center gap-1 font-medium text-foreground">
                    <svg class="h-4 w-4 fill-accent text-accent" viewBox="0 0 24 24"><path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/></svg>
                    {{ $avgRating > 0 ? $avgRating : $place->rating }}
                    @if($reviewsCount > 0)
                        <span class="text-muted-foreground">({{ $reviewsCount }} відгуків)</span>
                    @endif
                </span>
                <span class="flex items-center gap-1">
                    <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                    {{ $place->area }}
                </span>
            </div>
            <div class="mt-6 space-y-4 text-lg leading-relaxed text-foreground/90">
                @foreach($place->description as $paragraph)
                    <p class="text-pretty">{{ $paragraph }}</p>
                @endforeach
            </div>
        </div>

        <aside class="h-fit rounded-2xl border border-border bg-card p-6">
            <p class="font-serif text-lg font-semibold">Інформація</p>
            <dl class="mt-5 space-y-4">
                <div class="flex items-start gap-3">
                    <svg class="mt-0.5 h-5 w-5 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M20 21v-2a4 4 0 00-4-4H8a4 4 0 00-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
                    <div>
                        <dt class="text-xs text-muted-foreground">Категорія</dt>
                        <dd class="text-sm font-medium">{{ $place->category->label ?? '' }}</dd>
                    </div>
                </div>
                <div class="flex items-start gap-3">
                    <svg class="mt-0.5 h-5 w-5 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                    <div>
                        <dt class="text-xs text-muted-foreground">Адреса</dt>
                        <dd class="text-sm font-medium">{{ $place->address }}</dd>
                    </div>
                </div>
                <div class="flex items-start gap-3">
                    <svg class="mt-0.5 h-5 w-5 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><path d="M12 6v6l4 2"/></svg>
                    <div>
                        <dt class="text-xs text-muted-foreground">Години роботи</dt>
                        <dd class="text-sm font-medium">{{ $place->hours }}</dd>
                    </div>
                </div>
                <div class="flex items-start gap-3">
                    <svg class="mt-0.5 h-5 w-5 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M22 16.92v3a2 2 0 01-2.18 2 19.79 19.79 0 01-8.63-3.07 19.5 19.5 0 01-6-6 19.79 19.79 0 01-3.07-8.67A2 2 0 014.11 2h3a2 2 0 012 1.72c.127.96.361 1.903.7 2.81a2 2 0 01-.45 2.11L8.09 9.91a16 16 0 006 6l1.27-1.27a2 2 0 012.11-.45c.907.339 1.85.573 2.81.7A2 2 0 0122 16.92z"/></svg>
                    <div>
                        <dt class="text-xs text-muted-foreground">Телефон</dt>
                        <dd class="text-sm font-medium">{{ $place->phone }}</dd>
                    </div>
                </div>
            </dl>
            <a href="https://www.google.com/maps/dir/?api=1&destination={{ urlencode($place->address . ', Кропивницький') }}" target="_blank" rel="noopener noreferrer" class="mt-6 block w-full rounded-full bg-primary px-6 py-3 text-center text-sm font-semibold text-primary-foreground transition-transform hover:scale-[1.02]">Прокласти маршрут</a>
        </aside>
    </div>

    {{-- Відгуки --}}
    <section class="mt-16 border-t border-border pt-16">
        <div class="flex items-end justify-between gap-4">
            <div>
                <p class="text-sm font-medium text-primary">Відгуки</p>
                <h2 class="mt-2 text-balance font-serif text-3xl font-bold tracking-tight sm:text-4xl">Що кажуть відвідувачі</h2>
            </div>
        </div>

        {{-- Форма відгуку --}}
        <div class="mt-8 rounded-2xl border border-border bg-card p-6 sm:p-8">
            <h3 class="font-serif text-lg font-semibold">Залишити відгук</h3>
            <form id="review-form" class="mt-4 space-y-4">
                <div class="grid gap-4 sm:grid-cols-2">
                    <div>
                        <label for="review-name" class="text-sm font-medium">Ім'я</label>
                        <input type="text" id="review-name" required placeholder="Ваше ім'я" class="mt-1.5 h-12 w-full rounded-xl border border-border bg-background px-4 text-sm outline-none transition-colors focus:border-primary">
                    </div>
                    <div>
                        <label class="text-sm font-medium">Оцінка</label>
                        <div class="mt-1.5 flex gap-1" id="rating-stars">
                            @for($i = 1; $i <= 5; $i++)
                                <button type="button" data-rating="{{ $i }}" class="star-btn h-10 w-10 rounded-lg border border-border text-2xl transition-colors hover:bg-secondary">
                                    ☆
                                </button>
                            @endfor
                            <input type="hidden" name="rating" id="rating-input" value="0">
                        </div>
                    </div>
                </div>
                <div>
                    <label for="review-comment" class="text-sm font-medium">Ваш відгук</label>
                    <textarea id="review-comment" rows="4" required placeholder="Розкажіть про свій досвід..." class="mt-1.5 w-full rounded-xl border border-border bg-background px-4 py-3 text-sm outline-none transition-colors focus:border-primary"></textarea>
                </div>
                <button type="submit" class="inline-flex items-center justify-center gap-2 rounded-full bg-primary px-6 py-3 text-sm font-semibold text-primary-foreground transition-transform hover:scale-[1.02]">
                    Надіслати відгук
                    <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M22 2L11 13M22 2l-7 20-4-9-9-4 20-7z"/></svg>
                </button>
            </form>
            <div id="review-success" class="hidden mt-4 rounded-xl bg-green-500/10 p-4 text-center text-sm text-green-600">
                Дякуємо! Ваш відгук надіслано та з'явиться після модерації.
            </div>
        </div>

        {{-- Список відгуків --}}
        @if($reviews->count() > 0)
            <div class="mt-8 space-y-4">
                @foreach($reviews as $review)
                    <div class="rounded-2xl border border-border bg-card p-5">
                        <div class="flex items-center justify-between">
                            <div class="flex items-center gap-3">
                                <div class="flex h-10 w-10 items-center justify-center rounded-full bg-primary/10 text-primary font-semibold text-sm">
                                    {{ strtoupper(mb_substr($review->name, 0, 1)) }}
                                </div>
                                <div>
                                    <p class="font-medium text-sm">{{ $review->name }}</p>
                                    <p class="text-xs text-muted-foreground">{{ $review->created_at->format('d.m.Y') }}</p>
                                </div>
                            </div>
                            <div class="flex gap-0.5">
                                @for($i = 1; $i <= 5; $i++)
                                    <span class="{{ $i <= $review->rating ? 'text-accent' : 'text-muted-foreground/30' }}">★</span>
                                @endfor
                            </div>
                        </div>
                        <p class="mt-3 text-sm leading-relaxed text-foreground/80">{{ $review->comment }}</p>
                    </div>
                @endforeach
            </div>
        @else
            <p class="mt-8 text-center text-muted-foreground">Ще немає відгуків. Будьте першим!</p>
        @endif
    </section>
</div>
@endsection

@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        let selectedRating = 0;

        function setRating(rating) {
            selectedRating = rating;
            document.getElementById('rating-input').value = rating;
            document.querySelectorAll('.star-btn').forEach(function(btn, i) {
                btn.textContent = i < rating ? '★' : '☆';
                btn.classList.toggle('bg-accent/20', i < rating);
                btn.classList.toggle('text-accent', i < rating);
            });
        }

        document.querySelectorAll('.star-btn').forEach(function(btn) {
            btn.addEventListener('click', function() {
                setRating(parseInt(btn.dataset.rating, 10));
            });
        });

        document.getElementById('review-form').addEventListener('submit', function(e) {
            e.preventDefault();
            if (selectedRating === 0) {
                alert('Будь ласка, оберіть оцінку');
                return;
            }

            var name = document.getElementById('review-name').value;
            var comment = document.getElementById('review-comment').value;

            fetch('{{ route("reviews.store", $place->slug) }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                    'Accept': 'application/json',
                },
                body: JSON.stringify({
                    name: name,
                    rating: selectedRating,
                    comment: comment,
                }),
            }).then(function(response) {
                if (response.ok) {
                    document.getElementById('review-form').classList.add('hidden');
                    document.getElementById('review-success').classList.remove('hidden');
                }
            }).catch(function() {
                alert('Помилка надсилання. Спробуйте ще раз.');
            });
        });
    });
</script>
@endsection
