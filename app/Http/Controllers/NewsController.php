<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\News;
use Illuminate\View\View;

class NewsController extends Controller
{
    public function index(): View
    {
        $news = News::where('is_published', true)
            ->select('id', 'slug', 'tag', 'title', 'excerpt', 'date', 'read_time', 'image')
            ->latest()
            ->paginate(12);

        return view('news.index', compact('news'));
    }

    public function show(News $news): View
    {
        $item = $news;
        $related = News::where('id', '!=', $item->id)->where('is_published', true)->latest()->take(3)->get();

        return view('news.show', compact('item', 'related'));
    }
}
