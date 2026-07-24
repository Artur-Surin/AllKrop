<?php

namespace App\Http\Controllers;

use App\Models\Landmark;
use App\Services\ContentService;

class CityController extends Controller
{
    public function index()
    {
        $landmarks = Landmark::all();
        $stats = ContentService::stats();

        return view('city.index', compact('landmarks', 'stats'));
    }

    public function show($slug)
    {
        $item = Landmark::where('slug', $slug)->firstOrFail();

        return view('city.show', compact('item'));
    }
}
