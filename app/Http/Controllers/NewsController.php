<?php

namespace App\Http\Controllers;

use App\Models\News;

class NewsController extends Controller
{
    public function index()
    {
        $news = News::latest()->get();

        return view('news.index', compact('news'));
    }

    public function show($slug)
    {
        $item = News::where('slug', $slug)->firstOrFail();
        $related = News::where('id', '!=', $item->id)->latest()->take(3)->get();

        return view('news.show', compact('item', 'related'));
    }
}
