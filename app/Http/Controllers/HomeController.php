<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\Landmark;
use App\Models\News;
use App\Models\Place;
use App\Models\PlaceCategory;
use App\Services\ContentService;
use Illuminate\View\View;

class HomeController extends Controller
{
    public function index(): View
    {
        $news = News::where('is_published', true)
            ->select('id', 'slug', 'tag', 'title', 'excerpt', 'date', 'read_time', 'image')
            ->latest()
            ->take(3)
            ->get();

        $events = Event::where('is_published', true)
            ->select('id', 'slug', 'title', 'date', 'category', 'place', 'image')
            ->latest()
            ->take(3)
            ->get();

        $places = Place::with('category')
            ->where('is_published', true)
            ->select('id', 'slug', 'name', 'image', 'category_id', 'rating', 'area')
            ->take(3)
            ->get();

        $landmarks = Landmark::take(2)->get();
        $stats = ContentService::stats();
        $categories = PlaceCategory::all();

        return view('home', compact('news', 'events', 'places', 'landmarks', 'stats', 'categories'));
    }
}
