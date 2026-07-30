<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\TicketController;
use App\Http\Controllers\MidtransCallbackController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\EventController as AdminEventController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\PartnerController;
use App\Http\Controllers\Admin\TransactionController;
use App\Http\Controllers\Auth\GoogleController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\Admin\CheckinController;

/*
|--------------------------------------------------------------------------
| Public Routes
|--------------------------------------------------------------------------
*/

Route::get('/', [HomeController::class, 'index'])->name('home');

Route::get('/events/{event}', [EventController::class, 'show'])
    ->name('events.show');

Route::get('/auth/google', [GoogleController::class, 'redirect'])
    ->name('google.redirect');

Route::get('/auth/google/callback', [GoogleController::class, 'callback'])
    ->name('google.callback');

/*
|--------------------------------------------------------------------------
| Dashboard Redirect
|--------------------------------------------------------------------------
*/

Route::middleware('auth')->get('/dashboard', function () {

    if (auth()->user()->role === 'admin') {
        return redirect()->route('admin.dashboard');
    }

    return redirect()->route('tickets.mine');

})->name('dashboard');

/*
|--------------------------------------------------------------------------
| Midtrans Callback
|--------------------------------------------------------------------------
*/

Route::post('/midtrans/callback', [MidtransCallbackController::class, 'handle'])
    ->name('midtrans.callback');

/*
|--------------------------------------------------------------------------
| User Routes
|--------------------------------------------------------------------------
*/

Route::middleware('auth')->group(function () {

    /*
    |--------------------------------------------------------------------------
    | Checkout
    |--------------------------------------------------------------------------
    */

    Route::get('/checkout/{event}', [TicketController::class, 'checkout'])
        ->name('checkout');

    Route::post('/checkout/{event}', [TicketController::class, 'store'])
        ->name('checkout.store');

    Route::get('/payment/{order_id}', [TicketController::class, 'payment'])
        ->name('checkout.payment');

    Route::get('/payment/success/{order_id}', [TicketController::class, 'success'])
        ->name('checkout.success');

    /*
    |--------------------------------------------------------------------------
    | Ticket
    |--------------------------------------------------------------------------
    */

    Route::get('/ticket/{transaction}', [TicketController::class, 'ticket'])
        ->name('ticket');

    Route::get('/my-tickets', [TicketController::class, 'myTickets'])
        ->name('tickets.mine');

    Route::get('/my-tickets/{transaction}', [TicketController::class, 'show'])
        ->name('tickets.show');

    /*
    |--------------------------------------------------------------------------
    | Review & Rating
    |--------------------------------------------------------------------------
    */

    Route::post('/events/{event}/review', [ReviewController::class, 'store'])
        ->name('reviews.store');

});

/*
|--------------------------------------------------------------------------
| Admin Routes
|--------------------------------------------------------------------------
*/

Route::middleware(['auth', 'admin'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {

        Route::get('/', [DashboardController::class, 'index'])
            ->name('dashboard');

        Route::resource('events', AdminEventController::class);

        // --- Transaksi & Laporan ---
        Route::get('/transactions', [TransactionController::class, 'index'])
            ->name('transactions.index');
        
        Route::get('/transactions/export', [TransactionController::class, 'export'])
            ->name('transactions.export');

        // --- Checkin Ticket ---
        Route::get('/checkin', [CheckinController::class, 'index'])
            ->name('checkin');

        Route::get('/checkin/{orderId}', [CheckinController::class, 'verify'])
            ->name('checkin.verify');

        // --- Categories (Membuat admin.categories, admin.categories.store, update, destroy) ---
        Route::resource('categories', CategoryController::class)
            ->except(['create', 'edit', 'show'])
            ->names([
                'index' => 'categories',
            ]);

        // --- Partners ---
        Route::get('/partners', [PartnerController::class, 'index'])
            ->name('partners.index');

        Route::get('/partners/create', [PartnerController::class, 'create'])
            ->name('partners.create');

        Route::post('/partners', [PartnerController::class, 'store'])
            ->name('partners.store');

    });

require __DIR__.'/auth.php';