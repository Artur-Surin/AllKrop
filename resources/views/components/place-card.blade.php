@props(['place'])

<a href="/places/{{ $place->slug ?? $place['slug'] }}" class="group block rounded-2xl border border-border bg-card transition-shadow hover:shadow-md">
    <div class="relative aspect-[4/3] overflow-hidden rounded-t-2xl">
        @if($place->image ?? $place['image'] ?? null)
            <img
                src="{{ $place->image ?? $place['image'] }}"
                alt="{{ $place->name ?? $place['name'] }}"
                class="h-full w-full object-cover transition-transform duration-300 group-hover:scale-105"
                loading="lazy"
                decoding="async"
            />
        @else
            <div class="flex h-full w-full items-center justify-center bg-muted text-muted-foreground">
                <x-icon name="MapPin" class="h-10 w-10 opacity-40" />
            </div>
        @endif

        @if($place->category ?? $place['category'] ?? null)
            <span class="absolute left-3 top-3 inline-flex items-center rounded-full bg-background/80 px-2.5 py-1 text-xs font-medium backdrop-blur-sm">
                {{ $place->category ?? $place['category'] }}
            </span>
        @endif
    </div>

    <div class="p-4">
        <h3 class="font-serif text-lg font-semibold tracking-tight leading-snug">{{ $place->name ?? $place['name'] }}</h3>

        <div class="mt-2 flex items-center justify-between text-sm text-muted-foreground">
            @if($place->area ?? $place['area'] ?? null)
                <span class="flex items-center gap-1">
                    <x-icon name="MapPin" class="h-3.5 w-3.5" />
                    {{ $place->area ?? $place['area'] }}
                </span>
            @endif

            @if($place->rating ?? $place['rating'] ?? null)
                <span class="flex items-center gap-1">
                    <x-icon name="Star" class="h-3.5 w-3.5 text-amber-500" />
                    {{ $place->rating ?? $place['rating'] }}
                </span>
            @endif
        </div>
    </div>
</a>
