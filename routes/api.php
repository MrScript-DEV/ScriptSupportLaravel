<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\TicketController;
use App\Http\Controllers\Api\UserController;

Route::post('register', [AuthController::class, 'register'])->name('register');
Route::post('login', [AuthController::class, 'login'])->name('login');
Route::post('logout', [AuthController::class, 'logout'])->middleware('auth:sanctum')->name('logout');

Route::middleware('auth:sanctum')->group(function () {
    Route::prefix('users')->name('users.')->controller(UserController::class)->group(function () {
        Route::get('/', 'index')->middleware('can:viewAllUser')->name('users.index');
        Route::get('/{id}', 'show')->name('users.show');
        Route::post('/', 'create')->middleware('can:createUser')->name('users.create');
        Route::put('/{id}', 'update')->name('users.update');
        Route::delete('/{id}/soft', 'delete')->middleware('can:deleteUser')->name('users.delete');
        Route::delete('/{id}', 'destroy')->middleware('can:destroyUser')->name('users.destroy');
    });

    Route::prefix('tickets')->name('tickets.')->controller(TicketController::class)->group(function () {
        Route::get('/', 'index')->name('tickets.index');
        Route::get('/{id}', 'show')->name('tickets.show');
        Route::post('/', 'create')->middleware('can:createTicket')->name('tickets.create');
        Route::put('/{id}', 'update')->middleware('can:editTicket')->name('tickets.update');
        Route::patch('/{id}/rating', 'updateRating')->name('tickets.updateRating');
        Route::delete('/{id}/soft', 'delete')->middleware('can:deleteTicket')->name('tickets.delete');
        Route::delete('/{id}', 'destroy')->middleware('can:destroyTicket')->name('tickets.destroy');
    });
});
