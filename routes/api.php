<?php
use App\Http\Controllers\Admin\GuardController;
use App\Http\Controllers\Api\ReportController;
use App\Http\Controllers\Api\AttendanceController;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\ScheduleController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\LocationController;

Route::post('/login', [UserController::class, 'login']);

Route::middleware('auth.guard')->group(function () {
    // dashboard
    Route::get('/get-user', [UserController::class, 'getUser']);
    Route::get('/today-presence', [AttendanceController::class, 'getToday']);
    Route::get('/history-presence', [AttendanceController::class, 'getAll']);
    Route::post('/permission', [AttendanceController::class, 'postPermission']);
    Route::get('/today-report', [ReportController::class, 'hasReportedToday']);
    Route::post('/check-in/{id}', [AttendanceController::class, 'checkIn']);
    Route::post('/check-out/{id}', [AttendanceController::class, 'checkOut']);

    // schedule
    Route::get('/schedule', [ScheduleController::class, 'show']);
    // map
    Route::apiResource('locations', LocationController::class);
    // report
    Route::get('/history-report', [ReportController::class, 'getAll']);
    Route::post('/report/store', [ReportController::class, 'postReport']);

    // photo
    Route::get('/guard-photo/{id}', [GuardController::class, 'getPhoto']);

    Route::post('/logout', [UserController::class, 'logout']);
});
