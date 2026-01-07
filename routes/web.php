<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SensorController;

Route::get('/', function () {
    return redirect('/sensor');
});

Route::get('/sensor', [SensorController::class, 'index']);
Route::get('/sensor/create', [SensorController::class, 'create']);
Route::post('/sensor', [SensorController::class, 'store']);
