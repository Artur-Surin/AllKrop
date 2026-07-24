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
}
