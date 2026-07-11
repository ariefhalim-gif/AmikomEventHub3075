<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\TicketController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\EventController as AdminEventController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\PartnerController;

Route::get('/', [HomeController::class, 'index'])->name('home');

Route::get('/event', [EventController::class, 'detail'])->name('event.detail');

Route::get('/checkout', [TicketController::class, 'checkout'])->name('checkout');

Route::get('/ticket', [TicketController::class, 'ticket'])->name('ticket');

Route::prefix('admin')->name('admin.')->group(function () {

    Route::get('/', [DashboardController::class, 'index'])
        ->name('dashboard');

    Route::resource('events', AdminEventController::class);

    Route::get('/transactions', [DashboardController::class, 'transactions'])
        ->name('transactions');

    Route::get('/categories', [CategoryController::class, 'index'])
        ->name('categories');

    Route::get('/partners', [PartnerController::class, 'index'])
        ->name('partners.index');

    Route::get('/partners/create', [PartnerController::class, 'create'])
        ->name('partners.create');

    Route::post('/partners', [PartnerController::class, 'store'])
        ->name('partners.store');

});