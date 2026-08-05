<div class="mx-auto max-w-5xl px-4 py-8 sm:px-6">
    <div class="mb-8 flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
        <div>
            <h1 class="font-serif text-2xl font-bold text-foreground sm:text-3xl">Мої заклади</h1>
            <p class="mt-1 text-sm text-muted-foreground">Керування закладами, які ви додали на міський портал Кропивницького</p>
        </div>
        <div>
            <a href="{{ route('places.create') }}" class="inline-flex items-center gap-2 rounded-xl bg-primary px-4 py-2.5 text-sm font-semibold text-primary-foreground shadow transition hover:bg-primary/90">
                <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                Додати новий заклад
            </a>
        </div>
    </div>

    @if($places->isEmpty())
        <div class="rounded-3xl border border-border bg-card p-12 text-center shadow-sm">
            <div class="mx-auto mb-4 flex h-16 w-16 items-center justify-center rounded-2xl bg-secondary text-muted-foreground">
                <svg class="h-8 w-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/></svg>
            </div>
            <h3 class="font-serif text-lg font-semibold text-foreground">Ви ще не додали жодного закладу</h3>
            <p class="mt-1 text-sm text-muted-foreground">Додайте свій ресторан, магазин, сервіс або компанію, щоб мешканці міста дізналися про вас!</p>
            <div class="mt-6">
                <a href="{{ route('places.create') }}" class="rounded-xl bg-primary px-5 py-2.5 text-sm font-semibold text-primary-foreground shadow hover:bg-primary/90">
                    Додати свій заклад
                </a>
            </div>
        </div>
    @else
        <div class="space-y-4">
            @foreach($places as $place)
                <div class="flex flex-col gap-4 rounded-2xl border border-border bg-card p-5 shadow-sm sm:flex-row sm:items-center sm:justify-between">
                    <div class="flex items-start gap-4">
                        <div class="h-20 w-24 shrink-0 overflow-hidden rounded-xl bg-secondary border border-border">
                            <img src="{{ $place->image_url }}" alt="{{ $place->name }}" class="h-full w-full object-cover">
                        </div>
                        <div>
                            <div class="flex flex-wrap items-center gap-2">
                                <h3 class="font-serif text-lg font-bold text-foreground">
                                    @if($place->is_published)
                                        <a href="{{ route('places.show', $place->slug) }}" class="hover:underline">
                                            {{ $place->name }}
                                        </a>
                                    @else
                                        {{ $place->name }}
                                    @endif
                                </h3>
                                <span class="rounded-full bg-secondary px-2.5 py-0.5 text-xs text-muted-foreground">
                                    {{ $place->category?->label ?? 'Категорія' }}
                                </span>
                            </div>
                            <p class="mt-1 text-xs text-muted-foreground">{{ $place->address }} ({{ $place->area }})</p>
                            <p class="mt-0.5 text-xs text-muted-foreground">Створено: {{ $place->created_at->format('d.m.Y H:i') }}</p>
                        </div>
                    </div>

                    <div class="flex flex-wrap items-center gap-3 self-end sm:self-center">
                        @if($place->is_published)
                            <span class="inline-flex items-center gap-1.5 rounded-full bg-emerald-500/10 px-3 py-1 text-xs font-semibold text-emerald-600 dark:text-emerald-400">
                                <span class="h-1.5 w-1.5 rounded-full bg-emerald-500"></span>
                                Опубліковано
                            </span>
                            <a href="{{ route('places.show', $place->slug) }}" class="rounded-lg border border-border px-3 py-1.5 text-xs font-medium text-foreground hover:bg-secondary">
                                Переглянути
                            </a>
                        @elseif(!empty($place->rejection_reason))
                            <div class="text-right">
                                <span class="inline-flex items-center gap-1.5 rounded-full bg-destructive/10 px-3 py-1 text-xs font-semibold text-destructive">
                                    <span class="h-1.5 w-1.5 rounded-full bg-destructive"></span>
                                    Відхилено
                                </span>
                                <p class="mt-1 text-[11px] text-destructive/80 max-w-xs">{{ $place->rejection_reason }}</p>
                            </div>
                        @else
                            <span class="inline-flex items-center gap-1.5 rounded-full bg-amber-500/10 px-3 py-1 text-xs font-semibold text-amber-600 dark:text-amber-400">
                                <span class="h-1.5 w-1.5 rounded-full bg-amber-500 animate-pulse"></span>
                                На модерації
                            </span>
                        @endif

                        <a href="{{ route('places.edit', $place) }}" class="rounded-lg bg-primary/10 px-3 py-1.5 text-xs font-semibold text-primary hover:bg-primary/20">
                            Редагувати
                        </a>
                    </div>
                </div>
            @endforeach
        </div>
    @endif
</div>
