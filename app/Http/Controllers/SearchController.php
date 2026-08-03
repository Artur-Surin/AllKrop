<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\Landmark;
use App\Models\News;
use App\Models\Place;
use Illuminate\View\View;

class SearchController extends Controller
{
    public function index(): View
    {
        $query = trim(request('q', ''));
        $results = collect();

        if ($query) {
            $q = $query;

            $results = $results->merge(
                News::where('is_published', true)
                    ->where(function ($sub) use ($q) {
                        $sub->where('title', 'LIKE', "%{$q}%")
                            ->orWhere('excerpt', 'LIKE', "%{$q}%")
                            ->orWhere('tag', 'LIKE', "%{$q}%");
                    })
                    ->select('id', 'slug', 'title', 'excerpt', 'image')
                    ->limit(10)
                    ->get()
                    ->map(fn ($item) => ['type' => 'Новини', 'title' => $item->title, 'excerpt' => $item->excerpt, 'href' => route('news.show', $item->slug), 'image' => $item->image])
            );

            $results = $results->merge(
                Event::where('is_published', true)
                    ->where(function ($sub) use ($q) {
                        $sub->where('title', 'LIKE', "%{$q}%")
                            ->orWhere('category', 'LIKE', "%{$q}%")
                            ->orWhere('place', 'LIKE', "%{$q}%");
                    })
                    ->select('id', 'slug', 'title', 'date', 'place', 'image')
                    ->limit(10)
                    ->get()
                    ->map(fn ($item) => ['type' => 'Афіша', 'title' => $item->title, 'excerpt' => $item->date.' · '.$item->place, 'href' => route('events.show', $item->slug), 'image' => $item->image])
            );

            $results = $results->merge(
                Place::where('is_published', true)
                    ->where(function ($sub) use ($q) {
                        $sub->where('name', 'LIKE', "%{$q}%")
                            ->orWhere('area', 'LIKE', "%{$q}%");
                    })
                    ->select('id', 'slug', 'name', 'address', 'image')
                    ->limit(10)
                    ->get()
                    ->map(fn ($item) => ['type' => 'Заклади', 'title' => $item->name, 'excerpt' => $item->address, 'href' => route('places.show', $item->slug), 'image' => $item->image])
            );

            $results = $results->merge(
                Landmark::where(function ($sub) use ($q) {
                    $sub->where('title', 'LIKE', "%{$q}%")
                        ->orWhere('description', 'LIKE', "%{$q}%");
                })
                    ->select('id', 'slug', 'title', 'description', 'image')
                    ->limit(10)
                    ->get()
                    ->map(fn ($item) => ['type' => 'Місто', 'title' => $item->title, 'excerpt' => is_array($item->description) ? implode(' ', $item->description) : $item->description, 'href' => route('city.show', $item->slug), 'image' => $item->image])
            );
        }

        return view('search', ['query' => $query, 'results' => $results]);
    }
}
