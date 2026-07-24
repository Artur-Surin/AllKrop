<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\TransportRoute;
use App\Services\ContentService;
use Illuminate\View\View;

class TransportController extends Controller
{
    public function index(): View
    {
        $routes = TransportRoute::all();
        $info = ContentService::transportInfo();

        return view('transport', compact('routes', 'info'));
    }

    public function show(string $number): View
    {
        $allRoutes = ContentService::transportRoutes();
        $route = null;

        foreach ($allRoutes as $r) {
            if ($r['number'] === $number) {
                $route = $r;
                break;
            }
        }

        if (!$route) {
            abort(404);
        }

        return view('transport.show', ['route' => $route, 'number' => $number]);
    }
}
