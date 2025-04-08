<?php

use App\Http\Controllers\Api\Ticket\TicketDeleteController;
use App\Http\Controllers\Api\Ticket\TicketIndexController;
use App\Http\Controllers\Api\Ticket\TicketShowController;
use App\Http\Controllers\Api\Ticket\TicketStoreController;
use App\Http\Controllers\Api\Ticket\TicketUpdateController;
use App\Http\Controllers\Api\User\UserDeleteController;
use App\Http\Controllers\Api\User\UserIndexController;
use App\Http\Controllers\Api\User\UserShowController;
use App\Http\Controllers\Api\User\UserStoreController;
use App\Http\Controllers\Api\User\UserUpdateController;
use Illuminate\Support\Facades\Route;

Route::prefix('users')->name('users.')->group(function () {
    Route::get('/', [UserIndexController::class, 'index'])->name('users.index');
    Route::get('{userId}', [UserShowController::class, 'show'])->name('users.show');
    Route::post('/', [UserStoreController::class, 'store'])->name('users.store');
    Route::put('{userId}', [UserUpdateController::class, 'update'])->name('users.update');
    Route::delete('{userId}', [UserDeleteController::class, 'delete'])->name('users.delete');
});

Route::prefix('tickets')->name('tickets.')->group(function () {
    Route::get('/', [TicketIndexController::class, 'index'])->name('tickets.index');
    Route::get('{userId}', [TicketShowController::class, 'show'])->name('tickets.show');
    Route::post('/', [TicketStoreController::class, 'store'])->name('tickets.store');
    Route::put('{userId}', [TicketUpdateController::class, 'update'])->name('tickets.update');
    Route::delete('{userId}', [TicketDeleteController::class, 'delete'])->name('tickets.delete');
});
