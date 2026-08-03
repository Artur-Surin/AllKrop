<?php

declare(strict_types=1);

namespace App\Services;

use App\Models\Event as EventModel;
use App\Models\Landmark as LandmarkModel;
use App\Models\News as NewsModel;
use App\Models\Place as PlaceModel;
use App\Models\PlaceCategory;
use App\Models\ServiceGroup;
use App\Models\TransportRoute;
use Illuminate\Support\Facades\Cache;

class ContentService
{
    public static function navLinks(): array
    {
        return Cache::remember('navLinks', 3600, function () {
            return [
                ['label' => 'Новини', 'href' => '/news'],
                ['label' => 'Афіша', 'href' => '/events'],
                ['label' => 'Заклади', 'href' => '/places'],
                ['label' => 'Послуги', 'href' => '/services'],
                ['label' => 'Транспорт', 'href' => '/transport'],
                ['label' => 'Місто', 'href' => '/city'],
                ['label' => 'Контакти', 'href' => '/contacts'],
            ];
        });
    }

    public static function stats(): array
    {
        return Cache::remember('stats', 3600, function () {
            return [
                ['value' => '272', 'label' => 'роки історії міста'],
                ['value' => '215K+', 'label' => 'мешканців'],
                ['value' => '115', 'label' => 'км² площа міста'],
                ['value' => '40+', 'label' => 'подій щомісяця'],
            ];
        });
    }

    public static function news(): array
    {
        return Cache::remember('content_news_list', 1800, function () {
            $items = NewsModel::where('is_published', true)->latest()->get();

            return $items->map(function ($item) {
                return [
                    'id' => $item->id,
                    'slug' => $item->slug,
                    'tag' => $item->tag,
                    'title' => $item->title,
                    'excerpt' => $item->excerpt,
                    'date' => $item->date,
                    'read' => $item->read_time,
                    'image' => $item->image,
                    'source' => $item->source,
                    'source_url' => $item->source_url,
                    'body' => $item->body,
                ];
            })->toArray();
        });
    }

    public static function events(): array
    {
        return Cache::remember('content_events_list', 1800, function () {
            $items = EventModel::where('is_published', true)->latest()->get();

            return $items->map(function ($item) {
                return [
                    'id' => $item->id,
                    'slug' => $item->slug,
                    'image' => $item->image,
                    'title' => $item->title,
                    'category' => $item->category,
                    'date' => $item->date,
                    'time' => $item->time,
                    'place' => $item->place,
                    'price' => $item->price,
                    'description' => $item->description,
                ];
            })->toArray();
        });
    }

    public static function places(): array
    {
        return Cache::remember('content_places_list', 1800, function () {
            $items = PlaceModel::with('category')->where('is_published', true)->get();

            return $items->map(function ($item) {
                return [
                    'id' => $item->id,
                    'slug' => $item->slug,
                    'image' => $item->image_url,
                    'name' => $item->name,
                    'category' => $item->category?->label ?? '',
                    'category_key' => $item->category?->key ?? '',
                    'rating' => $item->rating,
                    'area' => $item->area,
                    'address' => $item->address,
                    'hours' => $item->hours,
                    'phone' => $item->phone,
                    'description' => $item->description,
                    'features' => $item->features,
                ];
            })->toArray();
        });
    }

    public static function landmarks(): array
    {
        return Cache::remember('content_landmarks_list', 3600, function () {
            $items = LandmarkModel::all();

            return $items->map(function ($item) {
                return [
                    'id' => $item->id,
                    'slug' => $item->slug,
                    'title' => $item->title,
                    'category' => $item->category,
                    'year' => $item->year,
                    'architect' => $item->architect,
                    'address' => $item->address,
                    'image' => $item->image,
                    'description' => $item->description,
                    'facts' => $item->facts,
                ];
            })->toArray();
        });
    }

    public static function getLandmark(string $slug): ?array
    {
        $landmarks = static::landmarks();
        foreach ($landmarks as $landmark) {
            if ($landmark['slug'] === $slug) {
                return $landmark;
            }
        }

        return null;
    }

    public static function enterpriseCategories(): array
    {
        return Cache::remember('enterpriseCategories', 3600, function () {
            return PlaceCategory::all()->map(function ($cat) {
                return [
                    'key' => $cat->key,
                    'label' => $cat->label,
                    'icon' => $cat->icon,
                    'description' => $cat->description,
                ];
            })->toArray();
        });
    }

    public static function categoryCount(string $key): int
    {
        return Cache::remember("categoryCount_{$key}", 1800, function () use ($key) {
            return PlaceModel::whereHas('category', fn ($q) => $q->where('key', $key))
                ->where('is_published', true)
                ->count();
        });
    }

    public static function serviceGroups(): array
    {
        return Cache::remember('serviceGroups', 3600, function () {
            // Джерело послуг можна брати з ServiceGroup моделей
            return ServiceGroup::with('items')->get()->map(function ($group) {
                return [
                    'category' => $group->category,
                    'items' => $group->items->map(function ($item) {
                        return [
                            'slug' => $item->slug,
                            'icon' => $item->icon,
                            'title' => $item->title,
                            'description' => $item->description,
                            'action' => $item->action,
                            'url' => $item->url,
                            'steps' => $item->steps,
                            'documents' => $item->documents,
                            'cost' => $item->cost,
                            'timeline' => $item->timeline,
                            'delivery' => $item->delivery,
                            'faq' => $item->faq,
                        ];
                    })->toArray(),
                ];
            })->toArray();
        });
    }

    public static function serviceCategories(): array
    {
        return [
            ['key' => 'docs', 'label' => 'Документи та реєстрація', 'icon' => 'FileText', 'description' => 'Довідки, реєстрація, «єМалятко»'],
            ['key' => 'housing', 'label' => 'Житло та комунальні', 'icon' => 'Home', 'description' => 'Оплата, ремонти, субсидії'],
            ['key' => 'community', 'label' => 'Громада та звернення', 'icon' => 'Users', 'description' => 'Міськрада, бюджет, гаряча лінія'],
        ];
    }

    public static function getServiceBySlug(string $slug): ?array
    {
        foreach (static::serviceGroups() as $group) {
            foreach ($group['items'] as $item) {
                if ($item['slug'] === $slug) {
                    $item['group_category'] = $group['category'];

                    return $item;
                }
            }
        }

        return null;
    }

    public static function getInstitution(string $serviceKey): ?array
    {
        $institutions = [
            'dovidky-ta-vytiahky' => [
                'name' => 'Центр надання адміністративних послуг (ЦНАП)',
                'address' => 'вул. Велика Перспективна, 40',
                'phone' => '+38 (052) 233-40-40',
                'url' => 'https://dozvil.kr-rada.gov.ua',
                'hours' => 'Пн–Пт: 08:00 – 17:00',
            ],
            'reiestratsiia-mistcya-prozhuvannya' => [
                'name' => 'Центр надання адміністративних послуг (ЦНАП)',
                'address' => 'вул. Велика Перспективна, 40',
                'phone' => '+38 (052) 233-40-40',
                'url' => 'https://dozvil.kr-rada.gov.ua',
                'hours' => 'Пн–Пт: 08:00 – 17:00',
            ],
            'reiestratsiia-novonarodzhenykh' => [
                'name' => 'Центр надання адміністративних послуг (ЦНАП єМалятко)',
                'address' => 'вул. Велика Перспективна, 40',
                'phone' => '+38 (052) 233-40-40',
                'url' => 'https://dozvil.kr-rada.gov.ua',
                'hours' => 'Пн–Пт: 08:00 – 17:00',
            ],
        ];

        return $institutions[$serviceKey] ?? null;
    }

    public static function serviceOffices(): array
    {
        return [
            [
                'name' => 'Центр надання адміністративних послуг',
                'address' => 'вул. Велика Перспективна, 40',
                'hours' => 'Пн–Пт: 08:00 – 17:00',
                'phone' => '+38 (052) 233-40-40',
                'lat' => 48.5079,
                'lng' => 32.2623,
            ],
            [
                'name' => 'ЦНАП — мікрорайон Ковалівка',
                'address' => 'вул. Космонавта Попова, 12',
                'hours' => 'Пн–Пт: 08:30 – 16:30',
                'phone' => '+38 (052) 255-12-12',
                'lat' => 48.5200,
                'lng' => 32.2350,
            ],
        ];
    }

    public static function transportRoutes(): array
    {
        return Cache::remember('transport_routes_v1', 3600, function () {
            $routes = TransportRoute::all();
            if ($routes->isNotEmpty()) {
                return $routes->map(function ($route) {
                    return [
                        'id' => $route->id,
                        'number' => (string) $route->number,
                        'type' => $route->type,
                        'from' => $route->route_from,
                        'to' => $route->route_to,
                        'route_from' => $route->route_from,
                        'route_to' => $route->route_to,
                        'interval' => $route->interval,
                        'stops' => $route->stops_list,
                    ];
                })->toArray();
            }

            return [];
        });
    }

    public static function transportInfo(): array
    {
        return Cache::remember('transportInfo', 3600, function () {
            return [
                ['icon' => 'CreditCard', 'title' => 'Електронний квиток', 'text' => 'Оплачуйте проїзд банківською карткою або через мобільний застосунок.'],
                ['icon' => 'MapPin', 'title' => 'Відстеження онлайн', 'text' => 'Дивіться рух транспорту в реальному часі.'],
                ['icon' => 'Accessibility', 'title' => 'Доступність', 'text' => 'Низькопідлогові електробуси обладнані для маломобільних пасажирів.'],
                ['icon' => 'Bike', 'title' => 'Велоінфраструктура', 'text' => 'Мережа велодоріжок та муніципальний велопрокат.'],
            ];
        });
    }
}
