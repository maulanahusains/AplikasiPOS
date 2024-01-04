<?php

use App\Http\Controllers\CRUD\CategoryController as ManageCategory;

use App\Http\Controllers\Petugas\DashboardController;
use Inertia\Inertia;
use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Application;
use App\Http\Controllers\ProfileController;


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
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

Route::get('/dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::get('/components/buttons', function () {
    return Inertia::render('Components/Buttons');
})->middleware(['auth', 'verified'])->name('components.buttons');

Route::middleware(['auth:petugas'])->prefix('adminp4nel')->group(function() {
    Route::middleware(['level:Admin'])->group(function() {
        Route::get('/dashboard', [DashboardController::class, 'dashboard_admin'])->name('dashboard.admin');

        Route::controller(ManageCategory::class)->prefix('crud_category')->group( function () {
            Route::get('/', 'index')->name('crud_category.index');
            Route::post('/store', 'store')->name('crud_category.store');
            Route::get('/edit/{category}', 'edit')->name('crud_category.edit');
            Route::put('/update/{category}', 'update')->name('crud_category.update');
            Route::get('/destroy/{category}', 'destroy')->name('crud_category.destroy');
        });
    });
});

Route::middleware(['auth:petugas'])->prefix('cash1er')->group(function() {
    Route::middleware(['level:Admin,Kasir'])->group(function() {
        Route::get('/dashboard', [DashboardController::class, 'dashboard_petugas'])->name('dashboard.petugas');
    });
});

require __DIR__ . '/auth.php';
