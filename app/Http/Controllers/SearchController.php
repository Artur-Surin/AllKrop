<?php

namespace App\Http\Controllers;

use App\Models\News;
use App\Models\Event;
use App\Models\Place;
use App\Models\Landmark;

class SearchController extends Controller
{
    public function index()
    {
        $query = trim(request('q', ''));
        $results = collect();

        if ($query) {
            $q = $query;

            $results = $results->merge(
                News::where('title', 'LIKE', "%{$q}%")
                    ->orWhere('excerpt', 'LIKE', "%{$q}%")
                    ->orWhere('tag', 'LIKE', "%{$q}%")
                    ->get()
                    ->map(fn($item) => ['type' => 'Новини', 'title' => $item->title, 'excerpt' => $item->excerpt, 'href' => route('news.show', $item->slug), 'image' => $item->image])
            );

            $results = $results->merge(
                Event::where('title', 'LIKE', "%{$q}%")
                    ->orWhere('category', 'LIKE', "%{$q}%")
                    ->orWhere('place', 'LIKE', "%{$q}%")
                    ->get()
                    ->map(fn($item) => ['type' => 'Афіша', 'title' => $item->title, 'excerpt' => $item->date . ' · ' . $item->place, 'href' => route('events.show', $item->slug), 'image' => $item->image])
            );

            $results = $results->merge(
                Place::where('name', 'LIKE', "%{$q}%")
                    ->orWhere('area', 'LIKE', "%{$q}%")
                    ->get()
                    ->map(fn($item) => ['type' => 'Заклади', 'title' => $item->name, 'excerpt' => $item->address, 'href' => route('places.show', $item->slug), 'image' => $item->image])
            );

            $results = $results->merge(
                Landmark::where('title', 'LIKE', "%{$q}%")
                    ->orWhere('description', 'LIKE', "%{$q}%")
                    ->get()
                    ->map(fn($item) => ['type' => 'Місто', 'title' => $item->title, 'excerpt' => $item->description, 'href' => route('city.show', $item->slug), 'image' => $item->image])
            );
        }

        return view('search', ['query' => $query, 'results' => $results]);
    }
}
