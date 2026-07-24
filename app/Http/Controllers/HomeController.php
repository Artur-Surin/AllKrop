<?php

namespace App\Http\Controllers;

use App\Models\News;
use App\Models\Event;
use App\Models\Place;
use App\Models\Landmark;
use App\Models\PlaceCategory;
use App\Services\ContentService;

class HomeController extends Controller
{
    public function index()
    {
        $news = News::latest()->take(3)->get();
        $events = Event::latest()->take(3)->get();
        $places = Place::with('category')->take(3)->get();
        $landmarks = Landmark::take(2)->get();
        $stats = ContentService::stats();
        $categories = PlaceCategory::all();

        return view('home', compact('news', 'events', 'places', 'landmarks', 'stats', 'categories'));
    }
}
