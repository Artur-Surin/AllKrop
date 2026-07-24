<x-filament-panels::page>
    <div class="grid gap-6 md:grid-cols-3 mb-6">
        <x-filament::section>
            <div class="text-center">
                <div class="text-3xl font-bold text-primary">{{ $this->getFeeds()['news'] ? count($this->getFeeds()['news']) : 0 }}</div>
                <div class="text-sm text-muted-foreground">Новинних джерел</div>
            </div>
        </x-filament::section>

        <x-filament::section>
            <div class="text-center">
                <div class="text-3xl font-bold text-primary">{{ $this->getFeeds()['events'] ? count($this->getFeeds()['events']) : 0 }}</div>
                <div class="text-sm text-muted-foreground">Джерел подій</div>
            </div>
        </x-filament::section>

        <x-filament::section>
            <div class="text-center">
                <div class="text-3xl font-bold text-primary">{{ $this->getNewsCount() + $this->getEventsCount() }}</div>
                <div class="text-sm text-muted-foreground">Імпортовано записів</div>
            </div>
        </x-filament::section>
    </div>

    <x-filament::section heading="Налаштовані джерела">
        <div class="space-y-4">
            @foreach($this->getFeeds() as $type => $feeds)
                <div>
                    <h3 class="text-lg font-semibold mb-2">{{ $type === 'news' ? 'Новини' : 'Події' }}</h3>
                    <div class="grid gap-3 md:grid-cols-2">
                        @foreach($feeds as $feed)
                            <div class="flex items-center justify-between rounded-lg border border-gray-200 p-3 dark:border-gray-700">
                                <div>
                                    <div class="font-medium">{{ $feed['name'] }}</div>
                                    <div class="text-xs text-muted-foreground truncate max-w-xs">{{ $feed['url'] }}</div>
                                </div>
                                <x-filament::badge :color="'success'">Активне</x-filament::badge>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endforeach
        </div>

        <div class="mt-4">
            <x-filament::button wire:click="runImport" wire:loading.attr="disabled" icon="heroicon-o-arrow-path">
                Запустити імпорт
            </x-filament::button>
        </div>
    </x-filament::section>

    <x-filament::section heading="Історія імпортів" class="mt-6">
        @php $logs = $this->getImportLogs(); @endphp
        @if($logs->isEmpty())
            <p class="text-sm text-muted-foreground">Ще не було імпортів.</p>
        @else
            <div class="overflow-x-auto">
                <table class="w-full text-sm">
                    <thead>
                        <tr class="border-b border-gray-200 dark:border-gray-700">
                            <th class="px-4 py-2 text-left font-medium">Джерело</th>
                            <th class="px-4 py-2 text-left font-medium">Тип</th>
                            <th class="px-4 py-2 text-left font-medium">Знайдено</th>
                            <th class="px-4 py-2 text-left font-medium">Імпортовано</th>
                            <th class="px-4 py-2 text-left font-medium">Пропущено</th>
                            <th class="px-4 py-2 text-left font-medium">Статус</th>
                            <th class="px-4 py-2 text-left font-medium">Дата</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($logs as $log)
                            <tr class="border-b border-gray-100 dark:border-gray-800">
                                <td class="px-4 py-3">{{ $log->feed_name }}</td>
                                <td class="px-4 py-3">
                                    <span class="inline-flex items-center rounded-full px-2 py-1 text-xs font-medium {{ $log->feed_type === 'news' ? 'bg-blue-100 text-blue-700 dark:bg-blue-900/30 dark:text-blue-300' : 'bg-green-100 text-green-700 dark:bg-green-900/30 dark:text-green-300' }}">
                                        {{ $log->feed_type === 'news' ? 'Новини' : 'Події' }}
                                    </span>
                                </td>
                                <td class="px-4 py-3">{{ $log->items_found }}</td>
                                <td class="px-4 py-3">{{ $log->items_imported }}</td>
                                <td class="px-4 py-3">{{ $log->items_skipped }}</td>
                                <td class="px-4 py-3">
                                    <span class="inline-flex items-center rounded-full px-2 py-1 text-xs font-medium {{ $log->status === 'success' ? 'bg-green-100 text-green-700 dark:bg-green-900/30 dark:text-green-300' : 'bg-red-100 text-red-700 dark:bg-red-900/30 dark:text-red-300' }}">
                                        {{ $log->status === 'success' ? 'Успішно' : 'Помилка' }}
                                    </span>
                                </td>
                                <td class="px-4 py-3 text-muted-foreground">{{ $log->created_at->diffForHumans() }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif
    </x-filament::section>
</x-filament-panels::page>
