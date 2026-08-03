<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Services\ContentService;
use Illuminate\Http\Response;
use Illuminate\View\View;

class CityController extends Controller
{
    public function index(): View
    {
        $landmarks = ContentService::landmarks();
        $stats = ContentService::stats();

        return view('city.index', compact('landmarks', 'stats'));
    }

    public function show(string $slug): View|Response
    {
        $landmark = ContentService::getLandmark($slug);

        if (! $landmark) {
            abort(404);
        }

        // Пропонуємо 3 інші пам'ятки тієї ж або будь-якої категорії
        $related = collect(ContentService::landmarks())
            ->where('slug', '!=', $slug)
            ->take(3)
            ->values()
            ->toArray();

        return view('city.show', compact('landmark', 'related'));
    }
}
