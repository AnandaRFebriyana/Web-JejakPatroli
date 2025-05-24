<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Location;
use App\Models\Attendance;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class LocationController extends Controller {
    /**
     * Display a listing of the resource.
     */
    public function index() {
        // Get the latest location for each attendance
        $locations = Location::with(['guardRelation', 'attendance', 'attendance.shift'])
            ->select([
                'locations.id',
                'locations.guard_id',
                'locations.attendance_id',
                'locations.latitude',
                'locations.longitude',
                'locations.created_at',
                'locations.updated_at'
            ])
            ->whereIn('locations.id', function($query) {
                $query->select(DB::raw('MAX(id)'))
                    ->from('locations')
                    ->groupBy('attendance_id');
            })
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        // Calculate active status based on last update time and attendance status
        $locations->each(function ($location) {
            $isWithinTimeLimit = $location->created_at->diffInMinutes(now()) <= 30;
            $isAttendanceActive = $location->attendance && !$location->attendance->check_out_time;
            $location->is_active = $isWithinTimeLimit && $isAttendanceActive;
        });

        return view('pages.location.location', [
            'title' => 'Data Lokasi Patroli',
            'locations' => $locations,
        ]);
    }

    public function loctrack() {
        // Get all unique attendance IDs that have locations
        $attendances = Location::select('attendance_id')
            ->distinct()
            ->pluck('attendance_id');

        // Get all locations for these attendances
        $allLocations = Location::whereIn('attendance_id', $attendances)
            ->with(['guardRelation', 'attendance', 'attendance.shift'])
            ->orderBy('created_at', 'asc')
            ->get()
            ->groupBy('attendance_id');

        return view('pages.location.locationtrack', [
            'title' => 'Tracking Lokasi Satpam',
            'allLocations' => $allLocations,
            'showAllTracks' => true
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create() {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request) {
        $validate = $request->validate([
            'latitude' => 'required|numeric',
            'longitude' => 'required|numeric',
            'attendance_id' => 'required|exists:attendances,id',
            'guard_id' => 'required|exists:guards,id',
        ]);

        Location::create($validate);
        
        if ($request->ajax()) {
            return response()->json(['success' => 'Berhasil menambah data lokasi!']);
        }
        return redirect('/location')->with('success', 'Berhasil menambah data lokasi!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Location $location) {
        return redirect()->away("https://www.google.com/maps?q={$location->latitude},{$location->longitude}");
    }

    public function showtrack(Location $location) {
        // Get all tracking points for this attendance session
        $trackingPoints = Location::where('attendance_id', $location->attendance_id)
            ->orderBy('created_at', 'asc')
            ->get();

        // Calculate if patrol is still active
        $isWithinTimeLimit = $location->created_at->diffInMinutes(now()) <= 30;
        $isAttendanceActive = $location->attendance && !$location->attendance->check_out_time;
        $location->is_active = $isWithinTimeLimit && $isAttendanceActive;
        
        return view('pages.location.locationtrack', [
            'title' => 'Tracking Lokasi Satpam',
            'location' => $location,
            'trackingPoints' => $trackingPoints,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Location $location) {
        return response()->json([
            'id' => $location->id,
            'latitude' => $location->latitude,
            'longitude' => $location->longitude,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Location $location) {
        $validate = $request->validate([
            'latitude' => 'required|numeric',
            'longitude' => 'required|numeric',
        ]);

        $location->update($validate);
        
        if ($request->ajax()) {
            return response()->json(['success' => 'Berhasil mengubah data lokasi!']);
        }
        return redirect('/location')->with('success', 'Berhasil mengubah data lokasi!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Location $location) {
        Location::destroy($location->id);
        return redirect('/location')->with('success', 'Berhasil menghapus data!');
    }
}
