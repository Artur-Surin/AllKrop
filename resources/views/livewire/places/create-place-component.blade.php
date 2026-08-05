<div class="mx-auto max-w-3xl px-4 py-8 sm:px-6">
    @if ($submitted)
        <div class="rounded-3xl border border-primary/20 bg-primary/5 p-8 text-center shadow-lg">
            <div class="mx-auto mb-4 flex h-16 w-16 items-center justify-center rounded-2xl bg-primary text-primary-foreground">
                <svg class="h-8 w-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                </svg>
            </div>
            <h2 class="font-serif text-2xl font-bold text-foreground">Заявку успішно відправлено!</h2>
            <p class="mt-2 text-sm text-muted-foreground">Дякуємо! Ваш заклад <strong>«{{ $name }}»</strong> успішно збережено та відправлено на модерацію. Після перевірки адміністратором він з'явиться в каталозі Кропивницького.</p>
            
            <div class="mt-6 flex flex-wrap justify-center gap-3">
                <a href="{{ route('my.places') }}" class="rounded-xl bg-primary px-5 py-2.5 text-sm font-semibold text-primary-foreground shadow transition hover:bg-primary/90">
                    Мої заклади
                </a>
                <a href="{{ route('places.index') }}" class="rounded-xl border border-border bg-background px-5 py-2.5 text-sm font-medium text-foreground transition hover:bg-secondary">
                    Переглянути каталог
                </a>
            </div>
        </div>
    @else
        <div class="rounded-3xl border border-border bg-card p-6 shadow-xl sm:p-8">
            <div class="mb-8">
                <div class="inline-flex items-center gap-2 rounded-full bg-primary/10 px-3 py-1 text-xs font-semibold text-primary">
                    <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                    Додавання закладу
                </div>
                <h1 class="mt-2 font-serif text-2xl font-bold text-foreground sm:text-3xl">Зареєструвати новий заклад</h1>
                <p class="mt-1 text-sm text-muted-foreground">Заповніть інформацію про ваше підприємство або заклад у Кропивницькому</p>
            </div>

            <form wire:submit.prevent="save" class="space-y-6">
                @if ($errors->any())
                    <div class="rounded-2xl border border-destructive/30 bg-destructive/10 p-4 text-destructive">
                        <div class="flex items-center gap-2 font-semibold">
                            <svg class="h-5 w-5 fill-none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                            Помилка заповнення! Будь ласка, виправте наступні поля:
                        </div>
                        <ul class="mt-2 list-disc list-inside text-xs space-y-1">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <!-- Honeypot -->
                <div class="hidden">
                    <input type="text" wire:model="website" tabindex="-1" autocomplete="off">
                </div>

                <!-- 1. Основна інформація -->
                <div class="space-y-4 rounded-2xl border border-border/60 bg-muted/20 p-5">
                    <h3 class="font-serif text-base font-semibold text-foreground">1. Основні дані</h3>

                    <div>
                        <label class="block text-sm font-medium text-foreground">Назва закладу <span class="text-destructive">*</span></label>
                        <input type="text" wire:model="name" placeholder="Наприклад: Кав'ярня «Scorini»"
                            class="mt-1 block w-full rounded-xl border border-border bg-background px-4 py-2.5 text-sm text-foreground focus:border-primary focus:outline-none focus:ring-2 focus:ring-primary/20">
                        @error('name') <span class="text-xs text-destructive mt-1 block">{{ $message }}</span> @enderror
                    </div>

                    <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
                        <div>
                            <label class="block text-sm font-medium text-foreground">Категорія <span class="text-destructive">*</span></label>
                            <select wire:model="category_id"
                                class="mt-1 block w-full rounded-xl border border-border bg-background px-4 py-2.5 text-sm text-foreground focus:border-primary focus:outline-none focus:ring-2 focus:ring-primary/20">
                                <option value="">Оберіть категорію</option>
                                @foreach($categories as $cat)
                                    <option value="{{ $cat->id }}">{{ $cat->label }}</option>
                                @endforeach
                            </select>
                            @error('category_id') <span class="text-xs text-destructive mt-1 block">{{ $message }}</span> @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-foreground">Район <span class="text-destructive">*</span></label>
                            <input type="text" wire:model="area" placeholder="Наприклад: Центр, Ковалівка, 101-й"
                                class="mt-1 block w-full rounded-xl border border-border bg-background px-4 py-2.5 text-sm text-foreground focus:border-primary focus:outline-none focus:ring-2 focus:ring-primary/20">
                            @error('area') <span class="text-xs text-destructive mt-1 block">{{ $message }}</span> @enderror
                        </div>
                    </div>

                    <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
                        <div>
                            <label class="block text-sm font-medium text-foreground">Адреса у Кропивницькому <span class="text-destructive">*</span></label>
                            <input type="text" wire:model="address" placeholder="вул. Велика Перспективна, 45"
                                class="mt-1 block w-full rounded-xl border border-border bg-background px-4 py-2.5 text-sm text-foreground focus:border-primary focus:outline-none focus:ring-2 focus:ring-primary/20">
                            @error('address') <span class="text-xs text-destructive mt-1 block">{{ $message }}</span> @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-foreground">Телефон для довідок <span class="text-destructive">*</span></label>
                            <input type="text" wire:model="phone" placeholder="+38 (050) 123-45-67"
                                class="mt-1 block w-full rounded-xl border border-border bg-background px-4 py-2.5 text-sm text-foreground focus:border-primary focus:outline-none focus:ring-2 focus:ring-primary/20">
                            @error('phone') <span class="text-xs text-destructive mt-1 block">{{ $message }}</span> @enderror
                        </div>
                    </div>
                </div>

                <!-- 2. Графік та Опис -->
                <div class="space-y-4 rounded-2xl border border-border/60 bg-muted/20 p-5">
                    <h3 class="font-serif text-base font-semibold text-foreground">2. Графік роботи та опис</h3>

                    <div>
                        <label class="block text-sm font-medium text-foreground">Години роботи <span class="text-destructive">*</span></label>
                        <textarea wire:model="hours" rows="3"
                            class="mt-1 block w-full rounded-xl border border-border bg-background px-4 py-2.5 text-sm text-foreground focus:border-primary focus:outline-none focus:ring-2 focus:ring-primary/20"
                            placeholder="пн-пт: 09:00 - 18:00&#10;сб-нд: 10:00 - 16:00"></textarea>
                        <span class="text-xs text-muted-foreground mt-1 block">Введіть графік роботи (можна декілька рядків)</span>
                        @error('hours') <span class="text-xs text-destructive mt-1 block">{{ $message }}</span> @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-foreground">Детальний опис закладу <span class="text-destructive">*</span></label>
                        <textarea wire:model="descriptionText" rows="5"
                            class="mt-1 block w-full rounded-xl border border-border bg-background px-4 py-2.5 text-sm text-foreground focus:border-primary focus:outline-none focus:ring-2 focus:ring-primary/20"
                            placeholder="Розкажіть про ваш заклад, меню, атмосфери, особливості... (кожен абзац з нового рядка)"></textarea>
                        @error('descriptionText') <span class="text-xs text-destructive mt-1 block">{{ $message }}</span> @enderror
                    </div>
                </div>

                <!-- 3. Зображення -->
                <div class="space-y-4 rounded-2xl border border-border/60 bg-muted/20 p-5">
                    <h3 class="font-serif text-base font-semibold text-foreground">3. Фотографії закладу</h3>

                    <div>
                        <label class="block text-sm font-medium text-foreground">Головне фото (обкладинка)</label>
                        <input type="file" wire:model="mainImage" accept="image/*"
                            class="mt-1.5 block w-full text-sm text-muted-foreground file:mr-4 file:rounded-xl file:border-0 file:bg-primary file:px-4 file:py-2 file:text-xs file:font-semibold file:text-primary-foreground hover:file:bg-primary/90 cursor-pointer">
                        @error('mainImage') <span class="text-xs text-destructive mt-1 block">{{ $message }}</span> @enderror

                        @if ($mainImage)
                            <div class="mt-3 relative h-32 w-48 overflow-hidden rounded-xl border border-border shadow-sm">
                                <img src="{{ $mainImage->temporaryUrl() }}" class="h-full w-full object-cover">
                            </div>
                        @endif
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-foreground">Галерея фотографій (до 10 фото)</label>
                        <input type="file" wire:model="galleryImages" multiple accept="image/*"
                            class="mt-1.5 block w-full text-sm text-muted-foreground file:mr-4 file:rounded-xl file:border-0 file:bg-secondary file:px-4 file:py-2 file:text-xs file:font-semibold file:text-foreground hover:file:bg-secondary/80 cursor-pointer">
                        @error('galleryImages.*') <span class="text-xs text-destructive mt-1 block">{{ $message }}</span> @enderror

                        @if ($galleryImages)
                            <div class="mt-3 flex flex-wrap gap-2">
                                @foreach ($galleryImages as $img)
                                    <div class="relative h-20 w-24 overflow-hidden rounded-lg border border-border">
                                        <img src="{{ $img->temporaryUrl() }}" class="h-full w-full object-cover">
                                    </div>
                                @endforeach
                            </div>
                        @endif
                    </div>
                </div>

                <!-- 4. Оцінки/Характеристики -->
                <div class="space-y-4 rounded-2xl border border-border/60 bg-muted/20 p-5">
                    <div class="flex items-center justify-between">
                        <h3 class="font-serif text-base font-semibold text-foreground">4. Послуги та особливості</h3>
                        <button type="button" wire:click="addFeatureGroup"
                            class="text-xs font-semibold text-primary hover:underline">
                            + Додати групу послуг
                        </button>
                    </div>

                    @foreach($features as $index => $feat)
                        <div class="flex flex-col gap-2 rounded-xl border border-border bg-background p-3 sm:flex-row sm:items-center">
                            <div class="sm:w-1/3">
                                <input type="text" wire:model="features.{{ $index }}.group" placeholder="Група (наприклад: Зал)"
                                    class="w-full rounded-lg border border-border px-3 py-1.5 text-xs text-foreground focus:border-primary focus:outline-none">
                            </div>
                            <div class="flex-1">
                                <input type="text" wire:model="features.{{ $index }}.items" placeholder="Пункти через кому (наприклад: Wi-Fi, Літня тераса)"
                                    class="w-full rounded-lg border border-border px-3 py-1.5 text-xs text-foreground focus:border-primary focus:outline-none">
                            </div>
                            @if(count($features) > 1)
                                <button type="button" wire:click="removeFeatureGroup({{ $index }})"
                                    class="self-end text-xs text-destructive hover:underline sm:self-center">
                                    Видалити
                                </button>
                            @endif
                        </div>
                    @endforeach
                </div>

                <div class="pt-2">
                    <button type="submit" wire:loading.attr="disabled"
                        class="w-full rounded-xl bg-primary py-3.5 text-base font-semibold text-primary-foreground shadow-lg transition-all hover:bg-primary/90 active:scale-[0.99] disabled:opacity-50">
                        <span wire:loading.remove>Відправити заклад на модерацію</span>
                        <span wire:loading>Збереження та завантаження фото...</span>
                    </button>
                </div>
            </form>
        </div>
    @endif
</div>
