<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\Place;
use App\Models\PlaceCategory;
use Illuminate\View\View;

class PlaceController extends Controller
{
    public function index(): View
    {
        $places = Place::with('category')
            ->select('id', 'slug', 'name', 'image', 'category_id', 'rating', 'area')
            ->paginate(12);
        $categories = PlaceCategory::all();

        return view('places.index', compact('places', 'categories'));
    }

    public function show(Place $place): View
    {
        $category = $place->category;

        return view('places.show', compact('place', 'category'));
    }

    public function category(string $key): View
    {
        $category = PlaceCategory::where('key', $key)->firstOrFail();
        $places = Place::where('category_id', $category->id)->get();
        $categories = PlaceCategory::all();

        return view('places.category', compact('category', 'places', 'categories'));
    }
}
