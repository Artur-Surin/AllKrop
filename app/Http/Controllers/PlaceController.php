<?php

namespace App\Http\Controllers;

use App\Models\Place;
use App\Models\PlaceCategory;

class PlaceController extends Controller
{
    public function index()
    {
        $places = Place::with('category')->get();
        $categories = PlaceCategory::all();

        return view('places.index', compact('places', 'categories'));
    }

    public function show($slug)
    {
        $place = Place::with('category')->where('slug', $slug)->firstOrFail();
        $category = $place->category;

        return view('places.show', compact('place', 'category'));
    }

    public function category($key)
    {
        $category = PlaceCategory::where('key', $key)->firstOrFail();
        $places = Place::where('category_id', $category->id)->get();
        $categories = PlaceCategory::all();

        return view('places.category', compact('category', 'places', 'categories'));
    }
}
