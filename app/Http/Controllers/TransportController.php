<?php

namespace App\Http\Controllers;

use App\Models\TransportRoute;
use App\Services\ContentService;

class TransportController extends Controller
{
    public function index()
    {
        $routes = TransportRoute::all();
        $info = ContentService::transportInfo();

        return view('transport', compact('routes', 'info'));
    }

    public function show(string $number)
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
