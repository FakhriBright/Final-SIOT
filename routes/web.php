<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\SensorController;
use App\Http\Controllers\DeviceController;
use App\Http\Controllers\SensorLogController;

/*
|--------------------------------------------------------------------------
| AUTH ROUTES
|--------------------------------------------------------------------------
*/
Route::get('/login', [AuthController::class, 'index'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.post');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthController::class, 'register'])->name('register.post');

Route::get('/forgot-password', [AuthController::class, 'showForgot'])->name('forgot');
Route::post('/forgot-password', [AuthController::class, 'forgot'])->name('forgot.post');

/*
|--------------------------------------------------------------------------
| PROTECTED ROUTES (ADMIN & USER)
|--------------------------------------------------------------------------
*/
Route::middleware(['auth'])->group(function () {

    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/sensor/history', [SensorLogController::class, 'history'])->name('sensor.history');

    // Sensor CRUD (Shared Access)
    Route::controller(SensorController::class)->group(function () {
        Route::get('/sensor', 'index')->name('sensor.index');
        Route::get('/sensor/create', 'create')->name('sensor.create');
        Route::post('/sensor', 'store')->name('sensor.store');
        Route::get('/sensor/{id}/edit', 'edit')->name('sensor.edit');
        Route::put('/sensor/{id}', 'update')->name('sensor.update');
        Route::delete('/sensor/{id}', 'destroy')->name('sensor.destroy');
    });

    /*
    |--------------------------------------------------------------------------
    | ADMIN ONLY ROUTES
    |--------------------------------------------------------------------------
    */
   Route::middleware(['role:admin'])->group(function () {

        // Device Management
        Route::controller(DeviceController::class)->group(function () {
            Route::get('/device', 'index')->name('device.index');
            Route::get('/device/create', 'create')->name('device.create');
            Route::post('/device', 'store')->name('device.store');
            Route::get('/device/{device}/edit', 'edit')->name('device.edit');
            Route::put('/device/{device}', 'update')->name('device.update');
            Route::delete('/device/{device}', 'destroy')->name('device.destroy');
       });

        // User Management View
        Route::get('/users', function () {
            $users = App\Models\User::latest()->paginate(10);
            return view('users.index', compact('users'));
        })->name('users.index');

        // System Settings View
        Route::get('/settings', function () {
            return view('settings.index');
        })->name('settings.index');
    });

});