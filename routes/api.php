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
    
    // map & tracking
    Route::post('/locations', [LocationController::class, 'store']);
    Route::post('/update-location', [AttendanceController::class, 'updateLocation']);
    
    // report
    Route::get('/history-report', [ReportController::class, 'getAll']);
    Route::post('/report/store', [ReportController::class, 'postReport']);

    // photo
    Route::get('/guard-photo/{id}', [GuardController::class, 'getPhoto']);

    Route::post('/logout', [UserController::class, 'logout']);
});

Route::get('/locations/{location}/latest', function (App\Models\Location $location) {
    // Get the latest location for the same guard and attendance
    $latestLocation = App\Models\Location::where('guard_id', $location->guard_id)
        ->where('attendance_id', $location->attendance_id)
        ->latest()
        ->first();

    if (!$latestLocation) {
        return response()->json(['success' => false, 'message' => 'Location not found']);
    }

    // Calculate if patrol is still active
    $isWithinTimeLimit = $latestLocation->created_at->diffInMinutes(now()) <= 30;
    $isAttendanceActive = $latestLocation->attendance && !$latestLocation->attendance->check_out_time;
    $latestLocation->is_active = $isWithinTimeLimit && $isAttendanceActive;

    return response()->json([
        'success' => true,
        'location' => [
            'latitude' => $latestLocation->latitude,
            'longitude' => $latestLocation->longitude,
            'created_at' => $latestLocation->created_at,
            'is_active' => $latestLocation->is_active
        ]
    ]);
});
