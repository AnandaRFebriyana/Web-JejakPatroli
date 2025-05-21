<?php

use App\Http\Controllers\Admin\AttendanceController;
use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\GuardController;
use App\Http\Controllers\Admin\LocationController;
use App\Http\Controllers\Admin\ScheduleController;
use App\Http\Controllers\Admin\ReportController;

use Illuminate\Support\Facades\Route;

Route::get("/", [AuthController::class, 'landingpage'])->name('landingpage');
Route::get("/aboutus", [AuthController::class, 'landingabout'])->name('landingabout');
Route::get("/login", [AuthController::class, 'signin'])->name('sign-in');
Route::post("/login", [AuthController::class, 'authenticate']);
Route::post("/logout", [AuthController::class, 'logout']);

Route::middleware('auth:admin')->group(function (){
    Route::resource('/dashboard', DashboardController::class)->only('index','show');
    Route::post('/filter-permission', [DashboardController::class, 'filterData']);

    Route::resource('/guard', GuardController::class);
    Route::get('/guard/{id}/account', [GuardController::class, 'getAccount']);
    Route::get('/guard-photo/{id}', [GuardController::class, 'getPhoto']);
    Route::put('/guard/update/{id}', [GuardController::class, 'updatePass']);
    Route::put('/guard/{id}/delete', [GuardController::class, 'destroy']);


    Route::resource('/presence', AttendanceController::class);
    Route::post('/get-guard', [AttendanceController::class, 'getSatpam']);

    Route::resource('/location', LocationController::class)->only('index','show');
    Route::resource('/report', ReportController::class);


    Route::controller(ScheduleController::class)->group(function () {
        Route::get('/schedules', 'index');

        Route::prefix('/schedules/guard')->group(function () {
            Route::get('/create', 'createGuard');
            Route::post('/store', 'storeGuard');
            Route::get('/{id}/edit', 'editGuard');
            Route::put('/{id}', 'updateGuard');
            Route::delete('/{id}/delete', 'destroyGuard');
        });
        Route::prefix('/schedules/shift')->group(function () {
            Route::post('/store', 'storeShift');
            Route::get('/{id}/edit', 'editShift');
            Route::put('/{id}', 'updateShift');
            Route::delete('/{id}/delete', 'destroyShift');
        });
    });
});
