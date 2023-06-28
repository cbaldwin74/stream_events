<?php

use App\Http\Controllers\EventController;
use App\Http\Controllers\FollowerController;
use App\Http\Controllers\MerchSaleController;
use App\Http\Controllers\TwitchAuthController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => false, //Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', function () {
        return Inertia::render('Dashboard');
    })->name('dashboard');

    Route::controller(FollowerController::class)->group(function () {
        Route::get('followers/gained', 'gained');
    });

    Route::controller(EventController::class)->group(function () {
        Route::get('events/stream', 'stream');
        Route::get('events/revenue', 'totalRevenue');
    });

    Route::controller(MerchSaleController::class)->group(function () {
        Route::get('merch/top', 'topThree');
    });
});

Route::get('auth/redirect', [TwitchAuthController::class, 'redirect']);
Route::get('auth/callback', [TwitchAuthController::class, 'callback']);
