<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\Event;
use Illuminate\View\View;

class EventController extends Controller
{
    public function index(): View
    {
        $events = Event::where('is_published', true)
            ->select('id', 'slug', 'title', 'category', 'date', 'time', 'place', 'price', 'image')
            ->latest()
            ->paginate(12);

        return view('events.index', compact('events'));
    }

    public function show(Event $event): View
    {
        return view('events.show', compact('event'));
    }
}
