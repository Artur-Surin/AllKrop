<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\News;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\View\View;

class NewsController extends Controller
{
    public function index(Request $request): View
    {
        $currentTag = $request->string('tag')->trim()->toString();
        $searchQuery = $request->string('q')->trim()->toString();

        $tags = Cache::remember('news_active_tags', 3600, function () {
            return News::where('is_published', true)
                ->distinct()
                ->pluck('tag')
                ->filter()
                ->values()
                ->toArray();
        });

        if (empty($tags)) {
            $tags = ['Місто', 'Транспорт', 'Культура', 'Події', 'Спорт', 'Спільнота'];
        }

        $news = News::where('is_published', true)
            ->when($currentTag, fn ($query) => $query->where('tag', $currentTag))
            ->when($searchQuery, function ($query) use ($searchQuery) {
                $query->where(function ($q) use ($searchQuery) {
                    $q->where('title', 'like', "%{$searchQuery}%")
                        ->orWhere('excerpt', 'like', "%{$searchQuery}%");
                });
            })
            ->select('id', 'slug', 'tag', 'title', 'excerpt', 'date', 'read_time', 'image', 'created_at')
            ->latest()
            ->paginate(12)
            ->withQueryString();

        return view('news.index', compact('news', 'tags', 'currentTag', 'searchQuery'));
    }

    public function show(News $news): View
    {
        $item = $news;

        $related = News::where('id', '!=', $item->id)
            ->where('is_published', true)
            ->where('tag', $item->tag)
            ->latest()
            ->take(3)
            ->get();

        if ($related->count() < 3) {
            $excludeIds = $related->pluck('id')->push($item->id);
            $additional = News::whereNotIn('id', $excludeIds)
                ->where('is_published', true)
                ->latest()
                ->take(3 - $related->count())
                ->get();
            $related = $related->concat($additional);
        }

        return view('news.show', compact('item', 'related'));
    }
}
