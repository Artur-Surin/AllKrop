<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Place extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'slug',
        'image',
        'gallery',
        'name',
        'category_id',
        'rating',
        'area',
        'address',
        'hours',
        'phone',
        'description',
        'features',
        'is_published',
        'rejection_reason',
    ];

    public function getRouteKeyName(): string
    {
        return 'slug';
    }

    protected $casts = [
        'description' => 'array',
        'features' => 'array',
        'gallery' => 'array',
        'is_published' => 'boolean',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function getGalleryUrlsAttribute(): array
    {
        $gallery = $this->gallery;

        // Якщо gallery — рядок (Filament інколи зберігає JSON як рядок всередині JSON), декодуємо ще раз
        if (is_string($gallery)) {
            $gallery = json_decode($gallery, true);
        }

        if (empty($gallery) || ! is_array($gallery)) {
            return [];
        }

        return array_values(array_filter(array_map(function ($img) {
            if (empty($img)) {
                return null;
            }

            if (str_starts_with($img, 'http://') || str_starts_with($img, 'https://') || str_starts_with($img, '/')) {
                return $img;
            }

            return '/storage/'.ltrim($img, '/');
        }, $gallery)));
    }

    public function getImageUrlAttribute(): string
    {
        if (! empty($this->image)) {
            if (str_starts_with($this->image, 'http://') || str_starts_with($this->image, 'https://') || str_starts_with($this->image, '/')) {
                return $this->image;
            }

            return '/storage/'.ltrim($this->image, '/');
        }

        return match ($this->category?->key) {
            'food' => '/images/place-restaurant.png',
            'shops' => '/images/cat-shops.png',
            'culture' => '/images/place-gallery.png',
            'beauty' => '/images/cat-beauty.png',
            'education' => '/images/cat-education.png',
            'auto' => '/images/cat-auto.png',
            'finance' => '/images/cat-finance.png',
            'industry' => '/images/cat-industry.png',
            default => '/images/hero-city.png',
        };
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(PlaceCategory::class, 'category_id');
    }

    public function reviews(): HasMany
    {
        return $this->hasMany(Review::class)->where('is_approved', true)->latest();
    }

    public function allReviews(): HasMany
    {
        return $this->hasMany(Review::class)->latest();
    }

    public function getAverageRatingAttribute(): float
    {
        if ($this->relationLoaded('reviews')) {
            return round((float) ($this->reviews->avg('rating') ?? 0), 1);
        }

        return round((float) ($this->reviews()->avg('rating') ?? 0), 1);
    }

    public function getReviewsCountAttribute(): int
    {
        if ($this->relationLoaded('reviews')) {
            return $this->reviews->count();
        }

        return $this->reviews()->count();
    }

    /**
     * Повертає розпарсений та форматований графік роботи по днях тижня (пн - нд).
     */
    public function getWorkingScheduleAttribute(): array
    {
        $days = [
            1 => ['key' => 'пн', 'full' => 'Понеділок'],
            2 => ['key' => 'вт', 'full' => 'Вівторок'],
            3 => ['key' => 'ср', 'full' => 'Середа'],
            4 => ['key' => 'чт', 'full' => 'Четвер'],
            5 => ['key' => 'пт', 'full' => 'П\'ятниця'],
            6 => ['key' => 'сб', 'full' => 'Субота'],
            7 => ['key' => 'нд', 'full' => 'Неділя'],
        ];

        $todayIso = (int) now()->format('N');
        $raw = trim((string) ($this->hours ?? ''));

        if ($raw === '') {
            $result = [];
            foreach ($days as $num => $day) {
                $result[] = [
                    'day' => $day['key'],
                    'full_day' => $day['full'],
                    'hours' => '—',
                    'is_today' => ($num === $todayIso),
                    'is_closed' => false,
                ];
            }

            return $result;
        }

        $scheduleMap = [];
        $lines = array_filter(array_map('trim', explode("\n", $raw)));
        $dayKeys = array_column($days, 'key');

        foreach ($lines as $line) {
            if (preg_match('/^(пн|вт|ср|чт|пт|сб|нд)\s*[-–—]\s*(пн|вт|ср|чт|пт|сб|нд)[:\s]+(.+)$/ui', $line, $matches)) {
                $startKey = mb_strtolower($matches[1]);
                $endKey = mb_strtolower($matches[2]);
                $val = trim($matches[3]);

                $startIndex = array_search($startKey, $dayKeys, true);
                $endIndex = array_search($endKey, $dayKeys, true);

                if ($startIndex !== false && $endIndex !== false && $startIndex <= $endIndex) {
                    for ($i = $startIndex; $i <= $endIndex; $i++) {
                        $scheduleMap[$i + 1] = $val;
                    }
                }
            } elseif (preg_match('/^((?:пн|вт|ср|чт|пт|сб|нд)(?:\s*,\s*(?:пн|вт|ср|чт|пт|сб|нд))*)[:\s]+(.+)$/ui', $line, $matches)) {
                $foundDaysList = explode(',', mb_strtolower($matches[1]));
                $val = trim($matches[2]);

                foreach ($foundDaysList as $dKey) {
                    $dKey = trim($dKey);
                    $index = array_search($dKey, $dayKeys, true);
                    if ($index !== false) {
                        $scheduleMap[$index + 1] = $val;
                    }
                }
            }
        }

        $defaultTime = $raw;

        $result = [];
        foreach ($days as $num => $day) {
            $hoursStr = $scheduleMap[$num] ?? $defaultTime;

            $formattedHours = preg_replace('/\s*[-–—]\s*/u', ' - ', $hoursStr);
            $isClosed = (mb_strtolower($hoursStr) === 'закрито' || mb_strtolower($hoursStr) === 'вихідний');

            $result[] = [
                'day' => $day['key'],
                'full_day' => $day['full'],
                'hours' => $formattedHours,
                'is_today' => ($num === $todayIso),
                'is_closed' => $isClosed,
            ];
        }

        return $result;
    }
}
