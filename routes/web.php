<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\GanttController;

// Route::get('/', function () {
//     return view('/gantt');
// });

Route::get('/', [GanttController::class, 'index']);
Route::get('/gantt', [GanttController::class, 'index']);
Route::get('/ajax_data', [GanttController::class, 'getdata']);
Route::post('/gantt', [GanttController::class, 'create'])->name('gantt.create');
Route::post('/gantt_update', [GanttController::class, 'update']);
Route::post('/gantt_destroy', [GanttController::class, 'destroy']);
