<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\GantController;

Route::get('/', function () {
    return view('home');
});

Route::get('/gantt', [GantController::class, 'index']);
Route::get('/ajax_data', [GantController::class, 'getdata']);
Route::post('/gantt', [GantController::class, 'update']);
