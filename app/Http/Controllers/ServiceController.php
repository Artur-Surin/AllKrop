<?php

namespace App\Http\Controllers;

use App\Models\ServiceGroup;

class ServiceController extends Controller
{
    public function index()
    {
        $serviceGroups = ServiceGroup::with('items')->orderBy('position')->get();

        return view('services', compact('serviceGroups'));
    }
}
