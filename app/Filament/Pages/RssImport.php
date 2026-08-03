<?php

declare(strict_types=1);

namespace App\Filament\Pages;

use App\Models\Event;
use App\Models\News;
use App\Models\RssImportLog;
use Filament\Notifications\Notification;
use Filament\Pages\Page;
use Filament\Support\Icons\Heroicon;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Artisan;

class RssImport extends Page
{
    protected static string|\BackedEnum|null $navigationIcon = Heroicon::Signal;

    protected static string|\UnitEnum|null $navigationGroup = 'Контент';

    protected static ?string $navigationLabel = 'RSS Імпорт';

    protected static ?string $title = 'RSS Імпорт новин та подій';

    protected string $view = 'filament.pages.rss-import';

    public ?string $lastImportMessage = null;

    public function getFeeds(): array
    {
        return config('rss.feeds', []);
    }

    public function getImportLogs(): Collection
    {
        return RssImportLog::latest()->take(20)->get();
    }

    public function getNewsCount(): int
    {
        return News::whereNotNull('source')->count();
    }

    public function getEventsCount(): int
    {
        return Event::whereNotNull('source')->count();
    }

    public function runImport(): void
    {
        $this->lastImportMessage = null;

        Artisan::call('rss:import');

        $output = Artisan::output();

        Notification::make()
            ->title('Імпорт завершено')
            ->body($output)
            ->success()
            ->send();

        $this->dispatch('$refresh');
    }
}
