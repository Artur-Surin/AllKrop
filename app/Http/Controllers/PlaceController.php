<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\Place;
use App\Models\PlaceCategory;
use Illuminate\Support\Facades\Cache;
use Illuminate\View\View;

class PlaceController extends Controller
{
    public function index(): View
    {
        $activeCategoryKey = request('category');

        $query = Place::with('category')
            ->where('is_published', true)
            ->select('id', 'slug', 'name', 'image', 'category_id', 'rating', 'area');

        if ($activeCategoryKey) {
            $query->whereHas('category', fn ($q) => $q->where('key', $activeCategoryKey));
        }

        $places = $query->paginate(12)->withQueryString();
        $categories = Cache::remember('place_categories', 3600, fn () => PlaceCategory::all());

        return view('places.index', compact('places', 'categories', 'activeCategoryKey'));
    }

    public function show(Place $place): View
    {
        if (! $place->is_published) {
            abort(404);
        }

        // Eager load reviews один раз — без N+1 у шаблоні
        $place->load('reviews');

        $category = $place->category;

        $relatedPlaces = Place::with('category')
            ->where('category_id', $place->category_id)
            ->where('id', '!=', $place->id)
            ->where('is_published', true)
            ->select('id', 'slug', 'name', 'image', 'category_id', 'rating', 'area')
            ->limit(3)
            ->get();

        return view('places.show', compact('place', 'category', 'relatedPlaces'));
    }

    public function category(string $key): View
    {
        $category = PlaceCategory::where('key', $key)->firstOrFail();

        $places = Place::with('category')
            ->where('category_id', $category->id)
            ->where('is_published', true)
            ->paginate(12)
            ->withQueryString();

        $categories = Cache::remember('place_categories', 3600, fn () => PlaceCategory::all());

        return view('places.category', compact('category', 'places', 'categories'));
    }
}
