<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\TicketController;
use App\Http\Controllers\Api\MessageController;
use App\Http\Controllers\Api\PriorityController;
use App\Http\Controllers\Api\StatusController;

Route::post('register', [AuthController::class, 'register'])->name('register');
Route::post('login', [AuthController::class, 'login'])->name('login');

Route::middleware('auth:sanctum')->group(function () {
    Route::post('logout', [AuthController::class, 'logout'])->name('logout');

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

    Route::prefix('messages')->name('messages.')->controller(MessageController::class)->group(function () {
        Route::post('/', 'create')->middleware('can:createMessage')->name('messages.create');
        Route::put('/{id}', 'update')->middleware('can:editMessage')->name('messages.update');
        Route::delete('/{id}/soft', 'delete')->middleware('can:deleteMessage')->name('messages.delete');
        Route::delete('/{id}', 'destroy')->middleware('can:destroyMessage')->name('messages.destroy');
    });

    Route::prefix('priorities')->name('priorities.')->controller(PriorityController::class)->group(function () {
        Route::get('/', 'index')->middleware('can:viewAllPriority')->name('priorities.index');
        Route::get('/{id}', 'show')->middleware('can:viewAllPriority')->name('priorities.show');
        Route::post('/', 'create')->middleware('can:createPriority')->name('priorities.create');
        Route::put('/{id}', 'update')->middleware('can:editPriority')->name('priorities.update');
        Route::delete('/{id}/soft', 'delete')->middleware('can:deletePriority')->name('priorities.delete');
    });

    Route::prefix('statuses')->name('statuses.')->controller(StatusController::class)->group(function () {
        Route::get('/', 'index')->middleware('can:viewAllStatus')->name('statuses.index');
        Route::get('/{id}', 'show')->middleware('can:viewAllStatus')->name('statuses.show');
        Route::post('/', 'create')->middleware('can:createStatus')->name('statuses.create');
    });
});
