<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    ray()->showApp();
    ray('test');
    return view('welcome');
});
