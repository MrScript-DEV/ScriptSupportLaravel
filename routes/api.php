<?php

use App\Http\Controllers\Api\MessageController;
use App\Http\Controllers\Api\PriorityController;
use App\Http\Controllers\Api\RoleController;
use App\Http\Controllers\Api\StatusController;
use App\Http\Controllers\Api\TicketController;
use App\Http\Controllers\Api\UserController;
use Illuminate\Support\Facades\Route;

Route::apiResource('users', UserController::class);
Route::apiResource('tickets', TicketController::class);
Route::apiResource('roles', RoleController::class);
Route::apiResource('messages', MessageController::class);
Route::apiResource('priorities', PriorityController::class);
Route::apiResource('statuses', StatusController::class);
