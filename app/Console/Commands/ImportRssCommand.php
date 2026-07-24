<?php

declare(strict_types=1);

namespace App\Console\Commands;

use App\Models\Event;
use App\Models\News;
use App\Models\RssImportLog;
use App\Services\RssParserService;
use Illuminate\Console\Command;

class ImportRssCommand extends Command
{
    protected $signature = 'rss:import {--feed=} {--type=}';
    protected $description = 'Import news and events from RSS feeds';

    private int $imported = 0;
    private int $skipped = 0;
    private int $errors = 0;

    public function handle(RssParserService $parser): int
    {
        $feeds = config('rss.feeds', []);
        $specificFeed = $this->option('feed');
        $specificType = $this->option('type');

        $this->info('Starting RSS import...');

        foreach ($feeds as $type => $feedList) {
            if ($specificType && $type !== $specificType) {
                continue;
            }

            foreach ($feedList as $feed) {
                if ($specificFeed && $feed['name'] !== $specificFeed) {
                    continue;
                }

                $this->line("Processing: {$feed['name']} ({$type})");
                $this->processFeed($parser, $feed, $type);
            }
        }

        $this->newLine();
        $this->info("Import complete: {$this->imported} imported, {$this->skipped} skipped, {$this->errors} errors");

        return Command::SUCCESS;
    }

    private function processFeed(RssParserService $parser, array $feed, string $type): void
    {
        $xml = $parser->fetchFeed($feed['url']);

        $log = RssImportLog::create([
            'feed_name' => $feed['name'],
            'feed_type' => $type,
            'items_found' => 0,
            'items_imported' => 0,
            'items_skipped' => 0,
            'status' => 'success',
        ]);

        if (!$xml) {
            $log->update(['status' => 'error', 'error_message' => 'Failed to fetch or parse feed']);
            $this->error("  Failed to fetch: {$feed['url']}");
            $this->errors++;
            return;
        }

        $items = match ($type) {
            'news' => $parser->parseNews($xml, $feed['name']),
            'events' => $parser->parseEvents($xml, $feed['name']),
            default => [],
        };

        $log->update(['items_found' => count($items)]);
        $this->line("  Found " . count($items) . " items");

        foreach ($items as $item) {
            $this->importItem($type, $item);
        }

        $log->update([
            'items_imported' => $this->imported,
            'items_skipped' => $this->skipped,
        ]);
    }

    private function importItem(string $type, array $item): void
    {
        $modelClass = $type === 'news' ? News::class : Event::class;
        $existing = $modelClass::where('slug', $item['slug'])->first();

        if ($existing) {
            $this->skipped++;
            $this->line("  Skip: {$item['title']} (duplicate)");
            return;
        }

        try {
            $record = $modelClass::create($item);
            $this->imported++;
            $this->line("  Import: {$item['title']}");
        } catch (\Exception $e) {
            $this->errors++;
            $this->error("  Error importing: {$item['title']} — {$e->getMessage()}");
        }
    }
}
