<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Location;
use App\Models\TrackingLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LocationController extends Controller
{
    public function index()
    {
        $guardId = Auth::guard('guard')->id();
        $locations = Location::where('guard_id', $guardId)->get();
        
        return response()->json([
            'status' => 'success',
            'data' => $locations
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'latitude' => 'required|numeric|between:-90,90',
            'longitude' => 'required|numeric|between:-180,180',
            'shift_id' => 'required|exists:shift,id'
        ]);

        $validated['guard_id'] = Auth::guard('guard')->id();

        $location = Location::create($validated);

        // Create tracking log
        TrackingLog::create([
            'guard_id' => $validated['guard_id'],
            'latitude' => $validated['latitude'],
            'longitude' => $validated['longitude'],
            'created_at' => now()
        ]);

        return response()->json([
            'status' => 'success',
            'message' => 'Location recorded successfully',
            'data' => $location
        ], 201);
    }

    public function show($id)
    {
        $location = Location::with(['guardRelation'])->findOrFail($id);
        
        return response()->json([
            'status' => 'success',
            'data' => $location
        ]);
    }

    public function getTrackingHistory(Request $request)
    {
        $request->validate([
            'date' => 'nullable|date_format:Y-m-d'
        ]);

        $guardId = Auth::guard('guard')->id();
        $query = TrackingLog::where('guard_id', $guardId);

        if ($request->has('date')) {
            $query->whereDate('created_at', $request->date);
        }

        $trackingLogs = $query->orderBy('created_at', 'desc')->get();

        return response()->json([
            'status' => 'success',
            'data' => $trackingLogs
        ]);
    }
} 