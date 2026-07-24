<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\Landmark;
use App\Services\ContentService;
use Illuminate\View\View;

class CityController extends Controller
{
    public function index(): View
    {
        $landmarks = Landmark::all();
        $stats = ContentService::stats();

        return view('city.index', compact('landmarks', 'stats'));
    }

    public function show(Landmark $landmark): View
    {
        $item = $landmark;

        return view('city.show', compact('item'));
    }
}
