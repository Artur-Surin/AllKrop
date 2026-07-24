<?php

namespace App\Http\Controllers;

use App\Models\Event;

class EventController extends Controller
{
    public function index()
    {
        $events = Event::where('is_published', true)->latest()->get();

        return view('events.index', compact('events'));
    }

    public function show($slug)
    {
        $event = Event::where('slug', $slug)->where('is_published', true)->firstOrFail();

        return view('events.show', compact('event'));
    }
}
