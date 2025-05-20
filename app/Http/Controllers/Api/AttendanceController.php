<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\AttendanceResource;
use App\Models\Attendance;
use App\Models\Location;
use App\Models\Permission;
use App\Jobs\LocationTrackingJob;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class AttendanceController extends Controller {
    
    public function getAll() {
        $guardId = Auth::guard('guard')->id();
        $attendances = Attendance::where('guard_id', $guardId)
                                  ->whereNotNull('check_in_time')
                                  ->whereNotNull('check_out_time')
                                  ->whereNotNull('status')
                                  ->orderBy('updated_at', 'desc')
                                  ->get();
        return AttendanceResource::collection($attendances);
    }

    public function getToday() {
        $guardId = Auth::guard('guard')->id();
        $today = Carbon::today()->toDateString();
        $attendance = Attendance::where('guard_id', $guardId)
                                ->where('date', $today)
                                ->first();
        if ($attendance) {
            return new AttendanceResource($attendance);
        } else {
            return response()->json(['error' => 'No attendance found for today.'], 404);
        }
    }

    public function checkIn(Request $request, $id) {
        $validated = $request->validate([
            'check_in_time' => 'required|date_format:H:i:s',
            'photo' => 'required|image|mimes:jpeg,png,jpg|max:2048',
            'longitude' => 'required|numeric',
            'latitude' => 'required|numeric',
            'location_address' => 'required|string|max:255',
        ]);
    
        if ($request->hasFile('photo')) {
            $validated['photo'] = $request->file('photo')->store('photo-attendance', 'public');
        }
        
        $attendance = Attendance::findOrFail($id);
        
        // Get shift start time and add 15 minutes tolerance
        $shift_start = Carbon::createFromFormat('H:i:s', $attendance->shift->start_time);
        $late_threshold = $shift_start->copy()->addMinutes(15);
        $check_in = Carbon::createFromFormat('H:i:s', $validated['check_in_time']);
        
        // Determine status based on check-in time
        $status = 'Hadir';
        if ($check_in->gt($late_threshold)) {
            $status = 'Terlambat';
        }

        $attendance->update([
            'check_in_time' => $validated['check_in_time'],
            'photo' => $validated['photo'],
            'status' => $status,
            'longitude' => $validated['longitude'],
            'latitude' => $validated['latitude'],
            'location_address' => $validated['location_address'],
        ]);

        // Save initial location
        Location::create([
            'attendance_id' => $attendance->id,
            'guard_id' => Auth::guard('guard')->id(),
            'latitude' => $validated['latitude'],
            'longitude' => $validated['longitude'],
        ]);

        return response()->json(['message' => 'Successfully made a presence.'], 200);
    }

    public function checkOut(Request $request, $id) {
        $validated = $request->validate([
            'check_out_time' => 'required|date_format:H:i:s',
            'longitude' => 'required|numeric',
            'latitude' => 'required|numeric',
        ]);

        $attendance = Attendance::findOrFail($id);
        $attendance->update([
            'check_out_time' => $validated['check_out_time'],
        ]);

        // Save final location
        Location::create([
            'attendance_id' => $attendance->id,
            'guard_id' => Auth::guard('guard')->id(),
            'latitude' => $validated['latitude'],
            'longitude' => $validated['longitude'],
        ]);

        return response()->json(['message' => 'Successfully made a presence.'], 200);
    }

    public function updateLocation(Request $request) {
        $validated = $request->validate([
            'attendance_id' => 'required|exists:attendances,id',
            'latitude' => 'required|numeric',
            'longitude' => 'required|numeric'
        ]);

        $attendance = Attendance::findOrFail($validated['attendance_id']);

        // Check if attendance is still active (not checked out)
        if ($attendance->check_out_time) {
            return response()->json(['error' => 'Attendance already checked out'], 400);
        }

        // Dispatch job to save location
        LocationTrackingJob::dispatch(
            $validated['attendance_id'],
            Auth::guard('guard')->id(),
            $validated['latitude'],
            $validated['longitude']
        );

        return response()->json(['message' => 'Location update queued']);
    }

    public static function hasAttendedToday() {
        $guardId = Auth::guard('guard')->id();
        $today = Carbon::today()->toDateString();
        $attendance = Attendance::where('guard_id', $guardId)
                                ->where('date', $today)
                                ->whereNotNull('check_in_time')
                                ->first();
        return !is_null($attendance);
    }

    public function postPermission(Request $request) {
        $validated = $request->validate([
            'permission_date' => 'required',
            'reason' => 'required|string|max:150',
            'information' => 'nullable|file|max:2048'
        ]);
        $validated['guard_id'] = Auth::guard('guard')->id();

        if ($request->hasFile('information')) {
            $validated['information'] = $request->file('information')->store('permission-files', 'public');
        }
        $permission = Permission::create($validated);

        return response()->json([
            'message' => 'Permission created successfully', 
            'data' => $permission
        ], 201);
    }
}