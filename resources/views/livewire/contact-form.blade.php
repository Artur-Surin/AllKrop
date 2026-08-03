<div>
    @if ($submitted)
        <div class="flex flex-col items-center justify-center rounded-2xl border border-border bg-card p-10 text-center shadow-sm">
            <span class="flex h-14 w-14 items-center justify-center rounded-full bg-primary text-primary-foreground">
                <svg class="h-7 w-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                </svg>
            </span>
            <h2 class="mt-5 font-serif text-2xl font-bold">Дякуємо за звернення!</h2>
            <p class="mt-2 max-w-sm text-pretty text-muted-foreground">Ми отримали ваше повідомлення та відповімо найближчим часом на вказаний Email.</p>
            <button wire:click="sendAnother" type="button" class="mt-6 rounded-full border border-border px-5 py-2.5 text-sm font-medium transition-colors hover:bg-secondary">
                Надіслати ще одне повідомлення
            </button>
        </div>
    @else
        <form wire:submit.prevent="submit" class="rounded-2xl border border-border bg-card p-6 sm:p-8 shadow-sm">
            {{-- Honeypot field for anti-spam --}}
            <div class="hidden" aria-hidden="true">
                <input type="text" wire:model="website" tabindex="-1" autocomplete="off">
            </div>

            <div class="grid gap-5 sm:grid-cols-2">
                <div>
                    <label for="name" class="text-sm font-medium">Ім'я <span class="text-destructive">*</span></label>
                    <input type="text" id="name" wire:model.blur="name" required placeholder="Ваше ім'я"
                           class="mt-2 h-12 w-full rounded-xl border @error('name') border-destructive @else border-border @enderror bg-card px-4 text-sm outline-none transition-colors focus:border-primary">
                    @error('name')
                        <p class="mt-1.5 text-xs text-destructive">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="email" class="text-sm font-medium">Пошта <span class="text-destructive">*</span></label>
                    <input type="email" id="email" wire:model.blur="email" required placeholder="you@example.com"
                           class="mt-2 h-12 w-full rounded-xl border @error('email') border-destructive @else border-border @enderror bg-card px-4 text-sm outline-none transition-colors focus:border-primary">
                    @error('email')
                        <p class="mt-1.5 text-xs text-destructive">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div class="mt-5">
                <label for="subject" class="text-sm font-medium">Тема звернення <span class="text-destructive">*</span></label>
                <select id="subject" wire:model="subject" required
                        class="mt-2 h-12 w-full rounded-xl border border-border bg-card px-4 text-sm outline-none transition-colors focus:border-primary">
                    @foreach ($subjects as $key => $label)
                        <option value="{{ $key }}">{{ $label }}</option>
                    @endforeach
                </select>
                @error('subject')
                    <p class="mt-1.5 text-xs text-destructive">{{ $message }}</p>
                @enderror
            </div>

            <div class="mt-5">
                <label for="message" class="text-sm font-medium">Повідомлення <span class="text-destructive">*</span></label>
                <textarea id="message" wire:model.blur="message" rows="5" required placeholder="Ваше повідомлення…"
                          class="mt-2 w-full rounded-xl border @error('message') border-destructive @else border-border @enderror bg-card px-4 py-3 text-sm outline-none transition-colors focus:border-primary"></textarea>
                @error('message')
                    <p class="mt-1.5 text-xs text-destructive">{{ $message }}</p>
                @enderror
            </div>

            <button type="submit" wire:loading.attr="disabled"
                    class="mt-6 inline-flex items-center justify-center gap-2 rounded-full bg-primary px-6 py-3 text-sm font-semibold text-primary-foreground transition-all hover:scale-[1.02] disabled:opacity-70">
                <span wire:loading.remove wire:target="submit">Надіслати повідомлення</span>
                <span wire:loading wire:target="submit" class="inline-flex items-center gap-2">
                    <svg class="h-4 w-4 animate-spin" fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                    </svg>
                    Надсилання…
                </span>
                <svg wire:loading.remove wire:target="submit" class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path d="M22 2L11 13M22 2l-7 20-4-9-9-4 20-7z"/>
                </svg>
            </button>
        </form>
    @endif
</div>
