# Blade Refactor Agent

## Task

Extract duplicated Blade code across all page templates into reusable anonymous components, eliminating redundancy and ensuring consistency.

## Components to Create

### 1. `components/icon.blade.php`

```blade
@props(['name', 'class' => 'h-5 w-5'])

@php
    $icons = [
        'arrow-left' => '<path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5 3 12m0 0 7.5-7.5M3 12h18" />',
        'map-pin' => '<path stroke-linecap="round" stroke-linejoin="round" d="M15 10.5a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" /><path stroke-linecap="round" stroke-linejoin="round" d="M19.5 10.5c0 7.142-7.5 11.25-7.5 11.25S4.5 17.642 4.5 10.5a7.5 7.5 0 1 1 15 0Z" />',
        'clock' => '<path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />',
        'phone' => '<path stroke-linecap="round" stroke-linejoin="round" d="M2.25 6.75c0 8.284 6.716 15 15 15h2.25a2.25 2.25 0 0 0 2.25-2.25v-1.372c0-.516-.351-.966-.852-1.091l-4.423-1.106c-.44-.11-.902.055-1.173.417l-.97 1.293c-.282.376-.769.542-1.21.38a12.035 12.035 0 0 1-7.143-7.143c-.162-.441.004-.928.38-1.21l1.293-.97c.363-.271.527-.734.417-1.173L6.963 3.102a1.125 1.125 0 0 0-1.091-.852H4.5A2.25 2.25 0 0 0 2.25 4.5v2.25Z" />',
        'globe' => '<path stroke-linecap="round" stroke-linejoin="round" d="M12 21a9.004 9.004 0 0 0 8.716-6.747M12 21a9.004 9.004 0 0 1-8.716-6.747M12 21c2.485 0 4.5-4.03 4.5-9S14.485 3 12 3m0 18c-2.485 0-4.5-4.03-4.5-9S9.515 3 12 3m0 0a8.997 8.997 0 0 1 7.843 4.582M12 3a8.997 8.997 0 0 0-7.843 4.582m15.686 0A11.953 11.953 0 0 1 12 10.5c-2.998 0-5.74-1.1-7.843-2.918m15.686 0A8.959 8.959 0 0 1 21 12c0 .778-.099 1.533-.284 2.253m0 0A17.919 17.919 0 0 1 12 16.5c-3.162 0-6.133-.815-8.716-2.247m0 0A9.015 9.015 0 0 1 3 12c0-1.605.42-3.113 1.157-4.418" />',
        'calendar' => '<path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 0 1 2.25-2.25h13.5A2.25 2.25 0 0 1 21 7.5v11.25m-18 0A2.25 2.25 0 0 0 5.25 21h13.5A2.25 2.25 0 0 0 21 18.75m-18 0v-7.5A2.25 2.25 0 0 1 5.25 9h13.5A2.25 2.25 0 0 1 21 11.25v7.5" />',
        'newspaper' => '<path stroke-linecap="round" stroke-linejoin="round" d="M12 7.5h1.5m-1.5 3h1.5m-7.5 3h7.5m-7.5 3h7.5m3-9h3.375c.621 0 1.125.504 1.125 1.125V18a2.25 2.25 0 0 1-2.25 2.25M16.5 7.5V18a2.25 2.25 0 0 0 2.25 2.25M16.5 7.5V4.875c0-.621-.504-1.125-1.125-1.125H4.125C3.504 3.75 3 4.254 3 4.875V18a2.25 2.25 0 0 0 2.25 2.25h13.5" />',
        'building-library' => '<path stroke-linecap="round" stroke-linejoin="round" d="M12 21v-8.25M15.75 21v-8.25M8.25 21v-8.25M3 9l9-6 9 6m-1.5 12V10.332A48.36 48.36 0 0 0 12 9.75c-2.551 0-5.056.2-7.5.582V21" />',
        'bus' => '<path stroke-linecap="round" stroke-linejoin="round" d="M8.25 18.75a1.5 1.5 0 0 1-3 0m3 0a1.5 1.5 0 0 0-3 0m3 0h6m-9 0H3.375a1.125 1.125 0 0 1-1.125-1.125V14.25m17.25 4.5a1.5 1.5 0 0 1-3 0m3 0a1.5 1.5 0 0 0-3 0m3 0h1.125c.621 0 1.129-.504 1.09-1.124a17.902 17.902 0 0 0-3.213-9.193 2.056 2.056 0 0 0-1.58-.86H14.25M16.5 18.75h-2.25m0-11.177v-.958c0-.568-.422-1.048-.987-1.106a48.554 48.554 0 0 0-10.026 0 1.106 1.106 0 0 0-.987 1.106v7.635m12-6.677v6.677m0 4.5v-4.5m0 0h-12" />',
        'folder' => '<path stroke-linecap="round" stroke-linejoin="round" d="M2.25 12.75V12A2.25 2.25 0 0 1 4.5 9.75h15A2.25 2.25 0 0 1 21.75 12v.75m-8.69-6.44-2.12-2.12a1.5 1.5 0 0 0-1.061-.44H4.5A2.25 2.25 0 0 0 2.25 6v12a2.25 2.25 0 0 0 2.25 2.25h15A2.25 2.25 0 0 0 21.75 18V9a2.25 2.25 0 0 0-2.25-2.25h-5.379a1.5 1.5 0 0 1-1.06-.44Z" />',
    ];
@endphp

<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" {{ $attributes->merge(['class' => $class]) }}>
    {!! $icons[$name] ?? '' !!}
</svg>
```

### 2. `components/breadcrumb.blade.php`

```blade
@props(['items' => []])

@if ($items->isNotEmpty() || count($items) > 0)
    <nav aria-label="Хлібні крихти" class="mb-6">
        <ol class="flex flex-wrap items-center gap-1.5 text-sm text-muted-foreground">
            <li>
                <a href="{{ route('home') }}" class="hover:text-foreground transition-colors">Головна</a>
            </li>
            @foreach ($items as $item)
                <li class="flex items-center gap-1.5">
                    <span aria-hidden="true">/</span>
                    @if (isset($item['url']))
                        <a href="{{ $item['url'] }}" class="hover:text-foreground transition-colors">{{ $item['label'] }}</a>
                    @else
                        <span class="text-foreground font-medium" aria-current="page">{{ $item['label'] }}</span>
                    @endif
                </li>
            @endforeach
        </ol>
    </nav>
@endif
```

### 3. `components/page-header.blade.php`

```blade
@props(['eyebrow' => null, 'title', 'description' => null, 'crumbs' => null])

@if ($crumbs)
    <x-breadcrumb :items="$crumbs" />
@endif

<header class="mb-10">
    @if ($eyebrow)
        <p class="text-sm font-medium text-primary mb-2">{{ $eyebrow }}</p>
    @endif

    <h1 class="font-serif text-3xl sm:text-4xl lg:text-5xl font-bold tracking-tight text-foreground">
        {{ $title }}
    </h1>

    @if ($description)
        <p class="mt-4 text-lg text-muted-foreground max-w-2xl leading-relaxed">
            {{ $description }}
        </p>
    @endif
</header>
```

### 4. `components/place-card.blade.php`

```blade
@props(['place'])

<a href="{{ route('places.show', $place->slug) }}"
   class="group block rounded-2xl border border-border bg-card p-6 transition-all duration-200 hover:shadow-md hover:-translate-y-0.5">
    @if ($place->image)
        <div class="aspect-[16/10] overflow-hidden rounded-xl mb-4">
            <img src="{{ asset('storage/' . $place->image) }}"
                 alt="{{ $place->name }}"
                 class="h-full w-full object-cover transition-transform duration-300 group-hover:scale-105"
                 loading="lazy"
                 width="400"
                 height="250">
        </div>
    @endif

    <h3 class="font-serif text-lg font-semibold text-foreground group-hover:text-primary transition-colors">
        {{ $place->name }}
    </h3>

    @if ($place->category)
        <span class="inline-block mt-2 text-xs font-medium text-muted-foreground bg-muted rounded-full px-2.5 py-0.5">
            {{ $place->category->name }}
        </span>
    @endif

    @if ($place->address)
        <p class="mt-3 flex items-center gap-1.5 text-sm text-muted-foreground">
            <x-icon name="map-pin" class="h-4 w-4 shrink-0" />
            {{ $place->address }}
        </p>
    @endif
</a>
```

### 5. `components/event-card.blade.php`

```blade
@props(['event'])

<a href="{{ route('events.show', $event->slug) }}"
   class="group block rounded-2xl border border-border bg-card p-6 transition-all duration-200 hover:shadow-md hover:-translate-y-0.5">
    @if ($event->image)
        <div class="aspect-[16/10] overflow-hidden rounded-xl mb-4">
            <img src="{{ asset('storage/' . $event->image) }}"
                 alt="{{ $event->title }}"
                 class="h-full w-full object-cover transition-transform duration-300 group-hover:scale-105"
                 loading="lazy"
                 width="400"
                 height="250">
        </div>
    @endif

    <div class="flex items-center gap-2 text-sm text-muted-foreground mb-2">
        <x-icon name="calendar" class="h-4 w-4" />
        <time datetime="{{ $event->starts_at->format('Y-m-d\TH:i') }}">
            {{ $event->starts_at->format('d.m.Y, H:i') }}
        </time>
    </div>

    <h3 class="font-serif text-lg font-semibold text-foreground group-hover:text-primary transition-colors">
        {{ $event->title }}
    </h3>

    @if ($event->location)
        <p class="mt-2 flex items-center gap-1.5 text-sm text-muted-foreground">
            <x-icon name="map-pin" class="h-4 w-4 shrink-0" />
            {{ $event->location }}
        </p>
    @endif

    @if ($event->is_free)
        <span class="inline-block mt-3 text-xs font-medium text-green-600 bg-green-50 rounded-full px-2.5 py-0.5">
            Безкоштовно
        </span>
    @endif
</a>
```

### 6. `components/back-link.blade.php`

```blade
@props(['href', 'label' => 'Назад'])

<a href="{{ $href }}"
   class="inline-flex items-center gap-2 text-sm font-medium text-muted-foreground hover:text-foreground transition-colors mb-8">
    <x-icon name="arrow-left" class="h-4 w-4" />
    {{ $label }}
</a>
```

## Refactor Process

1. Identify duplicated markup patterns across all page views
2. Extract patterns into the corresponding component
3. Replace inline HTML with `<x-component-name>` calls
4. Ensure all components use `@props` with explicit types
5. Verify no business logic in components — presentation only

## Verification

- `php artisan view:cache` succeeds (all views compile)
- Visit every page in browser — verify no visual regressions
- Check page source — confirm component HTML renders correctly
- Grep for duplicated markup patterns — should be zero after refactor

## File Locations

```
resources/views/components/icon.blade.php
resources/views/components/breadcrumb.blade.php
resources/views/components/page-header.blade.php
resources/views/components/place-card.blade.php
resources/views/components/event-card.blade.php
resources/views/components/back-link.blade.php
```
