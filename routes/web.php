<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\NewsController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\PlaceController;
use App\Http\Controllers\CityController;
use App\Http\Controllers\SearchController;
use App\Http\Controllers\ServiceController;
use App\Http\Controllers\TransportController;
use App\Http\Controllers\ContactController;

Route::get('/', [HomeController::class, 'index'])->name('home');

Route::get('/search', [SearchController::class, 'index'])->name('search');

Route::get('/news', [NewsController::class, 'index'])->name('news.index');
Route::get('/news/{slug}', [NewsController::class, 'show'])->name('news.show');

Route::get('/events', [EventController::class, 'index'])->name('events.index');
Route::get('/events/{slug}', [EventController::class, 'show'])->name('events.show');

Route::get('/places/category/{key}', [PlaceController::class, 'category'])->name('places.category');
Route::get('/places', [PlaceController::class, 'index'])->name('places.index');
Route::get('/places/{slug}', [PlaceController::class, 'show'])->name('places.show');

Route::get('/city', [CityController::class, 'index'])->name('city.index');
Route::get('/city/{slug}', [CityController::class, 'show'])->name('city.show');

Route::get('/contacts', [ContactController::class, 'index'])->name('contacts');
Route::get('/services', [ServiceController::class, 'index'])->name('services');
Route::get('/services/{slug}', [ServiceController::class, 'show'])->name('services.show');
Route::get('/transport/{number}', [TransportController::class, 'show'])->name('transport.show');
Route::get('/transport', [TransportController::class, 'index'])->name('transport');

Route::get('/sitemap.xml', function () {
    $url = request()->getSchemeAndHttpHost();
    $xml = '<?xml version="1.0" encoding="UTF-8"?>';
    $xml .= '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">';
    $xml .= '<url><loc>'.$url.'/</loc><changefreq>daily</changefreq><priority>1.0</priority></url>';
    foreach (App\Models\News::all() as $n) $xml .= '<url><loc>'.$url.'/news/'.$n->slug.'</loc><changefreq>weekly</changefreq><priority>0.8</priority></url>';
    foreach (App\Models\Event::all() as $e) $xml .= '<url><loc>'.$url.'/events/'.$e->slug.'</loc><changefreq>weekly</changefreq><priority>0.8</priority></url>';
    foreach (App\Models\Place::all() as $p) $xml .= '<url><loc>'.$url.'/places/'.$p->slug.'</loc><changefreq>monthly</changefreq><priority>0.7</priority></url>';
    foreach (App\Models\Landmark::all() as $l) $xml .= '<url><loc>'.$url.'/city/'.$l->slug.'</loc><changefreq>monthly</changefreq><priority>0.6</priority></url>';
    $xml .= '</urlset>';
    return response($xml, 200)->header('Content-Type', 'application/xml');
});

// Відгуки
Route::post('/reviews/{place}', function (App\Models\Place $place) {
    $validated = request()->validate([
        'name' => 'required|string|max:255',
        'rating' => 'required|integer|min:1|max:5',
        'comment' => 'required|string',
    ]);

    $place->allReviews()->create([
        'name' => $validated['name'],
        'rating' => $validated['rating'],
        'comment' => $validated['comment'],
        'is_approved' => false,
    ]);

    return response()->json(['success' => true]);
})->name('reviews.store');

Route::fallback(function () {
    return response()->view('404', [], 404);
});
