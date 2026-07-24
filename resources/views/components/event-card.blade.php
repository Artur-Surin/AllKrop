@props(['event'])

<a href="/events/{{ $event->slug ?? $event['slug'] }}" class="group block rounded-2xl border border-border bg-card transition-shadow hover:shadow-md">
    <div class="relative aspect-[4/3] overflow-hidden rounded-t-2xl">
        @if($event->image ?? $event['image'] ?? null)
            <img
                src="{{ $event->image ?? $event['image'] }}"
                alt="{{ $event->title ?? $event['title'] }}"
                class="h-full w-full object-cover transition-transform duration-300 group-hover:scale-105"
                loading="lazy"
                decoding="async"
            />
        @else
            <div class="flex h-full w-full items-center justify-center bg-muted text-muted-foreground">
                <x-icon name="Calendar" class="h-10 w-10 opacity-40" />
            </div>
        @endif

        @if($event->date ?? $event['date'] ?? null)
            <div class="absolute left-3 top-3 flex flex-col items-center rounded-lg bg-background/80 px-2.5 py-1.5 text-center backdrop-blur-sm">
                <span class="text-[10px] font-medium uppercase leading-none text-muted-foreground">{{ \Carbon\Carbon::parse($event->date ?? $event['date'])->format('M') }}</span>
                <span class="mt-0.5 text-lg font-bold leading-none">{{ \Carbon\Carbon::parse($event->date ?? $event['date'])->format('d') }}</span>
            </div>
        @endif

        @if($event->category ?? $event['category'] ?? null)
            <span class="absolute right-3 top-3 inline-flex items-center rounded-full bg-background/80 px-2.5 py-1 text-xs font-medium backdrop-blur-sm">
                {{ $event->category ?? $event['category'] }}
            </span>
        @endif
    </div>

    <div class="p-4">
        <h3 class="font-serif text-lg font-semibold tracking-tight leading-snug">{{ $event->title ?? $event['title'] }}</h3>

        <ul class="mt-3 space-y-1.5 text-sm text-muted-foreground">
            @if($event->time ?? $event['time'] ?? null)
                <li class="flex items-center gap-1.5">
                    <x-icon name="Clock" class="h-3.5 w-3.5 shrink-0" />
                    {{ $event->time ?? $event['time'] }}
                </li>
            @endif

            @if($event->place ?? $event['place'] ?? null)
                <li class="flex items-center gap-1.5">
                    <x-icon name="MapPin" class="h-3.5 w-3.5 shrink-0" />
                    {{ $event->place ?? $event['place'] }}
                </li>
            @endif

            @if($event->price ?? $event['price'] ?? null)
                <li class="flex items-center gap-1.5">
                    <x-icon name="Ticket" class="h-3.5 w-3.5 shrink-0" />
                    {{ $event->price ?? $event['price'] }}
                </li>
            @endif
        </ul>
    </div>
</a>
