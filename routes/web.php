<?php

declare(strict_types=1);

use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\CityController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\NewsController;
use App\Http\Controllers\PlaceController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\SearchController;
use App\Http\Controllers\ServiceController;
use App\Http\Controllers\SitemapController;
use App\Http\Controllers\TransportController;
use App\Livewire\Places\CreatePlaceComponent;
use App\Livewire\Places\EditPlaceComponent;
use App\Livewire\Places\UserPlacesComponent;
use Illuminate\Support\Facades\Route;

Route::get('/', [HomeController::class, 'index'])->name('home');

// Авторизація користувачів
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);
});

Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth')->name('logout');

// Кабінет та додавання закладів
Route::middleware('auth')->group(function () {
    Route::get('/places/add', CreatePlaceComponent::class)->name('places.create');
    Route::get('/places/{place}/edit', EditPlaceComponent::class)->name('places.edit');
    Route::get('/my/places', UserPlacesComponent::class)->name('my.places');
});

Route::get('/search', [SearchController::class, 'index'])->name('search');

Route::get('/news', [NewsController::class, 'index'])->name('news.index');
Route::get('/news/{news:slug}', [NewsController::class, 'show'])->name('news.show');

Route::get('/events', [EventController::class, 'index'])->name('events.index');
Route::get('/events/{event:slug}', [EventController::class, 'show'])->name('events.show');

Route::get('/places/category/{key}', [PlaceController::class, 'category'])->name('places.category');
Route::get('/places', [PlaceController::class, 'index'])->name('places.index');
Route::get('/places/{place:slug}', [PlaceController::class, 'show'])->name('places.show');

Route::get('/city', [CityController::class, 'index'])->name('city.index');
Route::get('/city/{slug}', [CityController::class, 'show'])->name('city.show');

Route::get('/contacts', [ContactController::class, 'index'])->name('contacts');
Route::get('/services', [ServiceController::class, 'index'])->name('services');
Route::get('/services/{slug}', [ServiceController::class, 'show'])->name('services.show');
Route::get('/transport/{number}', [TransportController::class, 'show'])->name('transport.show');
Route::get('/transport', [TransportController::class, 'index'])->name('transport');

Route::get('/sitemap.xml', [SitemapController::class, 'index'])->name('sitemap');

// Відгуки
Route::post('/reviews/{place}', [ReviewController::class, 'store'])
    ->name('reviews.store')
    ->middleware('throttle:3,1');

Route::fallback(function () {
    return response()->view('404', [], 404);
});
