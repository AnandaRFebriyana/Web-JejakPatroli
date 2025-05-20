<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Location;
use App\Models\TrackingLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LocationController extends Controller
{
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
} 