<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\qrverify;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\MasterController;
use App\Http\Controllers\GuestController;
use Illuminate\Support\Facades\Route;
use App\Models\Event;
use App\Models\Guest;
use Carbon\Carbon;


Route::get('/', [MasterController::class, 'index'])->name('landing');
Route::get('/guest/{code}', [GuestController::class, 'showpublic'])->name('showpublic');


Route::get('/test-sms', [GuestController::class, 'testSms']);

Route::middleware(['auth'])->group(function () {
    // Route::get('/dashboard', function () {
    //     return view('dashboard');
    // })->name('dashboard');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});


Route::get('/about', function () {
    return view('about');
});


Route::get('/contact', function () {
    return view('contact');
});

Route::get('/pricing', function () {
    return view('pricing');
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
        Route::get('/card/export-image/{code}/{guest}', [GuestController::class, 'generateCardImage'])->name('generateCardImage');
        Route::get('/{event}/{guest}/card', [UserController::class, 'cardview'])->name('cardview');
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
        Route::post('/guests/import', [GuestController::class, 'importGuests'])->name('importGuests');
        // QR code JSON endpoint
        Route::get('/guest-qr/{guest}', function ($id) {
            $guest = App\Models\Guest::findOrFail($id);
            return response()->json([
                'qr_svg' => QrCode::size(150)->generate($guest->more ?? url('/guest/' . $guest->qrcode)),
                'link'   => $guest->more ?? url('/guest/' . $guest->qrcode)
            ]);
        })->name('guest.qr');

        // Delete guest
        Route::delete('/guest/{guest}', [App\Http\Controllers\GuestController::class, 'destroy'])->name('guest.destroy');
    });
