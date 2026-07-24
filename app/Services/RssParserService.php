<?php

declare(strict_types=1);

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use SimpleXMLElement;

class RssParserService
{
    public function fetchFeed(string $url): ?SimpleXMLElement
    {
        try {
            $response = Http::timeout(15)
                ->withHeaders(['User-Agent' => 'KropPortal/1.0 RSS Importer'])
                ->get($url);

            if ($response->failed()) {
                Log::warning("RSS feed fetch failed: {$url}", ['status' => $response->status()]);
                return null;
            }

            $xml = @simplexml_load_string($response->body());

            if ($xml === false) {
                Log::warning("RSS feed XML parse failed: {$url}");
                return null;
            }

            return $xml;
        } catch (\Exception $e) {
            Log::error("RSS feed error: {$url}", ['message' => $e->getMessage()]);
            return null;
        }
    }

    public function parseNews(SimpleXMLElement $feed, string $feedName): array
    {
        $items = [];
        $channel = $feed->channel ?? $feed;

        foreach ($channel->item as $item) {
            $title = (string) ($item->title ?? '');
            if (empty($title)) {
                continue;
            }

            $rawDate = (string) ($item->pubDate ?? '');
            $date = $this->formatDate($rawDate);

            $description = (string) ($item->description ?? '');
            $excerpt = $this->sanitizeContent($description);
            $body = $this->extractBody($description);

            $link = (string) ($item->link ?? '');

            $image = $this->extractImage($item) ?: config('rss.default_image', '/images/hero-city.png');

            $fullText = $title . ' ' . $excerpt;

            if (!$this->isRelatedToCity($fullText)) {
                continue;
            }

            $items[] = [
                'title' => $title,
                'slug' => $this->generateSlug($title),
                'tag' => $this->detectTag($title . ' ' . $excerpt),
                'excerpt' => mb_substr($excerpt, 0, 300),
                'date' => $date,
                'read_time' => $this->estimateReadTime($excerpt),
                'image' => $image,
                'body' => $body,
                'source' => $feedName,
                'source_url' => $link,
            ];
        }

        return $items;
    }

    public function parseEvents(SimpleXMLElement $feed, string $feedName): array
    {
        $items = [];
        $channel = $feed->channel ?? $feed;

        foreach ($channel->item as $item) {
            $title = (string) ($item->title ?? '');
            if (empty($title)) {
                continue;
            }

            $rawDate = (string) ($item->pubDate ?? '');
            $date = $this->formatDate($rawDate);

            $description = (string) ($item->description ?? '');
            $excerpt = $this->sanitizeContent($description);
            $body = $this->extractBody($description);

            $link = (string) ($item->link ?? '');

            $image = $this->extractImage($item) ?: config('rss.default_image', '/images/hero-city.png');

            $fullText = $title . ' ' . $excerpt;

            if (!$this->isRelatedToCity($fullText)) {
                continue;
            }

            $items[] = [
                'title' => $title,
                'slug' => $this->generateSlug($title),
                'category' => $this->detectEventCategory($title . ' ' . $excerpt),
                'date' => $date,
                'time' => $this->extractTime($excerpt),
                'place' => $this->extractPlace($excerpt),
                'price' => $this->extractPrice($excerpt),
                'image' => $image,
                'description' => $body,
                'source' => $feedName,
                'source_url' => $link,
            ];
        }

        return $items;
    }

    public function sanitizeContent(string $html): string
    {
        $text = strip_tags($html);
        $text = html_entity_decode($text, ENT_QUOTES, 'UTF-8');
        $text = preg_replace('/\s+/', ' ', $text);
        return trim($text);
    }

    public function generateSlug(string $title): string
    {
        $slug = transliterator_transliterate('Any-Latin; Latin-ASCII; Lower()', $title);
        $slug = preg_replace('/[^a-z0-9\-]/', '-', $slug);
        $slug = preg_replace('/-+/', '-', $slug);
        $slug = trim($slug, '-');
        return $slug ?: 'item-' . time();
    }

    private function formatDate(string $rawDate): string
    {
        if (empty($rawDate)) {
            return now()->format('d.m.Y');
        }

        $timestamp = strtotime($rawDate);
        if ($timestamp === false) {
            return now()->format('d.m.Y');
        }

        $months = [
            1 => 'січня', 2 => 'лютого', 3 => 'березня', 4 => 'квітня',
            5 => 'травня', 6 => 'червня', 7 => 'липня', 8 => 'серпня',
            9 => 'вересня', 10 => 'жовтня', 11 => 'листопада', 12 => 'грудня',
        ];

        $day = date('j', $timestamp);
        $month = $months[(int) date('n', $timestamp)];
        return "{$day} {$month}";
    }

    private function extractImage(SimpleXMLElement $item): string
    {
        $namespaces = $item->getNamespaces(true);

        if (isset($namespaces['media'])) {
            $media = $item->children('media', true);
            if (isset($media->content) && isset($media->content->attributes()->url)) {
                return (string) $media->content->attributes()->url;
            }
        }

        if (isset($namespaces['enclosure'])) {
            $enclosure = $item->children('enclosure', true);
            if (isset($enclosure->attributes()->url)) {
                return (string) $enclosure->attributes()->url;
            }
        }

        if (isset($item->enclosure) && isset($item->enclosure['url'])) {
            return (string) $item->enclosure['url'];
        }

        $description = (string) ($item->description ?? '');
        if (preg_match('/<img[^>]+src=["\']([^"\']+)["\']/', $description, $matches)) {
            return $matches[1];
        }

        return '';
    }

    private function extractBody(string $html): array
    {
        $clean = $this->sanitizeContent($html);
        $paragraphs = preg_split('/\n\s*\n/', $clean);
        $body = array_filter(array_map('trim', $paragraphs));
        return array_values($body) ?: [$clean ?: ''];
    }

    private function detectTag(string $text): string
    {
        $text = mb_strtolower($text);

        $tags = [
            'Транспорт' => ['транспорт', 'автобус', 'маршрут', 'електробус', 'тролейбус', 'метро', 'поїзд', 'зупинка', 'дорога'],
            'Культура' => ['культура', 'музей', 'театр', 'виставка', 'концерт', 'фестиваль', 'мистецтво', 'бібліотека'],
            'Спорт' => ['спорт', 'матч', 'гра', 'команда', 'чемпіонат', 'олімпіада', 'тренування', 'стадіон'],
            'Спільнота' => ['спільнота', 'волонтер', 'громада', 'зустріч', 'ініціатива', 'проєкт'],
            'Події' => ['подія', 'фестиваль', 'ярмарок', 'свято', 'день міста', 'концерт', 'виступ'],
        ];

        foreach ($tags as $tag => $keywords) {
            foreach ($keywords as $keyword) {
                if (str_contains($text, $keyword)) {
                    return $tag;
                }
            }
        }

        return 'Місто';
    }

    private function detectEventCategory(string $text): string
    {
        $text = mb_strtolower($text);

        $categories = [
            'Концерт' => ['концерт', 'музика', 'гурт', 'виступ', 'спів', 'джаз', 'рок', 'фолк'],
            'Ярмарок' => ['ярмарок', 'маркет', 'виставка продажу', 'базар'],
            'Театр' => ['театр', 'вистава', 'постановка', 'сцена', 'драма'],
            'Кіно' => ['кіно', 'фільм', 'показ', 'кінотеатр', 'прем\'єра'],
            'Виставка' => ['виставка', 'галерея', 'мистецтво', 'експозиція', 'картина'],
            'Родина' => ['родина', 'діти', 'сімейн', 'дитяч'],
        ];

        foreach ($categories as $category => $keywords) {
            foreach ($keywords as $keyword) {
                if (str_contains($text, $keyword)) {
                    return $category;
                }
            }
        }

        return 'Подія';
    }

    private function extractTime(string $text): string
    {
        if (preg_match('/(\d{1,2}[:.]\d{2})/', $text, $matches)) {
            return str_replace('.', ':', $matches[1]);
        }
        return '00:00';
    }

    private function extractPlace(string $text): string
    {
        $places = [
            'Центральна площа' => ['центральн', 'площ'],
            'Ковалівський парк' => ['ковалівк', 'парк'],
            'Дендропарк' => ['дендропарк'],
            'Театр ім. Кропивницького' => ['театр'],
            'Галерея сучасного мистецтва' => ['галерея'],
        ];

        $lower = mb_strtolower($text);
        foreach ($places as $place => $keywords) {
            foreach ($keywords as $keyword) {
                if (str_contains($lower, $keyword)) {
                    return $place;
                }
            }
        }

        return 'Кропивницький';
    }

    private function extractPrice(string $text): string
    {
        if (preg_match('/(\d+)\s*₴/', $text, $matches)) {
            return $matches[0];
        }
        if (preg_match('/безкоштовн/i', $text)) {
            return 'Безкоштовно';
        }
        if (preg_match('/вхід вільний/i', $text)) {
            return 'Безкоштовно';
        }
        return 'Безкоштовно';
    }

    private function estimateReadTime(string $text): string
    {
        $wordCount = str_word_count($text);
        $minutes = max(1, (int) ceil($wordCount / 200));
        return "{$minutes} хв";
    }

    private function isRelatedToCity(string $text): bool
    {
        $text = mb_strtolower($text);

        $keywords = [
            'кропивницький',
            'кропивницька',
            'кропивницького',
            'кропивницькому',
            'кропивницьку',
            'кіровоград',
            'кіровоградськ',
            'кіровоградщин',
            'обласний центр',
            'обласна рада',
            'міська рада',
            'міський голова',
        ];

        foreach ($keywords as $keyword) {
            if (mb_strpos($text, $keyword) !== false) {
                return true;
            }
        }

        return false;
    }
}
