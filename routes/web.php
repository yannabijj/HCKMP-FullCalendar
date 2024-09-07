<?php

use App\Http\Controllers\EventController;

Route::get('/calendar', function () {
    return view('calendar');
});

Route::get('/events', [EventController::class, 'index']);
Route::post('/events', [EventController::class, 'store']);
Route::put('/events/{event}', [EventController::class, 'update']);
Route::delete('/events/{event}', [EventController::class, 'destroy']);
