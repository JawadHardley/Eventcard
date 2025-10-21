<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\qrverify;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\MasterController;
use App\Http\Controllers\GuestController;
use Illuminate\Support\Facades\Route;


Route::get('/', [MasterController::class, 'index'])->name('landing');
Route::get('/guest/{code}', [GuestController::class, 'showpublic'])->name('showpublic');

Route::middleware(['auth'])->group(function () {
    // Route::get('/dashboard', function () {
    //     return view('dashboard');
    // })->name('dashboard');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';

// Admin routes
Route::prefix('admin')
    ->name('admin.')
    ->middleware(['auth', 'role:admin'])
    ->group(function () {
        Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');
        Route::get('users', [AdminController::class, 'users'])->name('users');
        Route::get('transactions', [AdminController::class, 'transactions'])->name('transactions');
        Route::post('/logout', [AuthenticatedSessionController::class, 'destroy'])
            ->name('logout');
    });

// User routes
Route::prefix('user')
    ->name('user.')
    ->middleware(['auth', 'role:user'])
    ->group(function () {
        Route::get('/dashboard', [UserController::class, 'dashboard'])->name('dashboard');
        Route::get('profile', [UserController::class, 'profile'])->name('profile');
        Route::post('/logout', [AuthenticatedSessionController::class, 'destroy'])
            ->name('logout');
        Route::get('/{event}/cameralog', [UserController::class, 'cameralog'])->name('cameralog');
        Route::get('/guestlist', [GuestController::class, 'guestlist'])->name('guestlist');
        Route::get('/verify-qr', [qrverify::class, 'verify'])->name('verify');
        Route::get('/verify-card', [qrverify::class, 'markfield'])->name('markfield');
        Route::get('/addevent', [EventController::class, 'addevent'])->name('addevent');
        Route::get('/eventlist', [EventController::class, 'eventlist'])->name('eventlist');
        Route::get('/eventview/{id}', [EventController::class, 'eventview'])->name('eventview');
        Route::post('/guestadd', [GuestController::class, 'guestadd'])->name('guestadd');
        Route::post('/guest/{id}/update', [GuestController::class, 'guestupdate'])->name('guestupdate');
        Route::post('/eventadd', [EventController::class, 'eventadd'])->name('eventadd');
        Route::post('/event/{id}/update', [EventController::class, 'eventupdate'])->name('eventupdate');
    });
