<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Services\ContentService;
use Illuminate\View\View;

class TransportController extends Controller
{
    public function index(): View
    {
        $routes = ContentService::transportRoutes();
        $info = ContentService::transportInfo();

        return view('transport', compact('routes', 'info'));
    }

    public function show(string $number): View
    {
        $allRoutes = ContentService::transportRoutes();
        $route = null;

        foreach ($allRoutes as $r) {
            if ((string) $r['number'] === (string) $number) {
                $route = $r;
                break;
            }
        }

        if (! $route) {
            abort(404);
        }

        $similarRoutes = array_values(array_filter(
            $allRoutes,
            fn ($r) => $r['type'] === $route['type'] && (string) $r['number'] !== (string) $route['number']
        ));

        return view('transport.show', compact('route', 'number', 'similarRoutes'));
    }
}
