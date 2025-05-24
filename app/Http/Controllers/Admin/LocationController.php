<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Location;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use App\Models\TrackingLog;

class LocationController extends Controller {
    /**
     * Display a listing of the resource.
     */
    public function index() {
        $title = 'Delete!';
        $text = "Are you sure you want to delete?";
        $location = Location::with('guardRelation')->get();
        $logs = TrackingLog::with(['guardRelation.schedules'])->get();
        confirmDelete($title, $text);
        $location = Location::with('guardRelation')->orderBy('created_at', 'desc')->first();

        return view('pages.location.location', [
            'logs' => $logs,
            'location' => $location,
            'title' => 'Data Lokasi Patroli',
        ]);
    }

    public function loctrack() {
        $locations = Location::with('guardRelation')
            ->orderBy('created_at', 'desc')
            ->take(10)  
            ->get();

        return view('pages.location.locationtrack', [
            'title' => 'Tracking Lokasi Satpam',
            'locations' => $locations,
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
            'location_name' => 'required|unique:locations',
        ],[
            'location_name.required' => 'Nama Lokasi harus diisi.',
            'location_name.unique' => 'Nama Lokasi sudah ada.'
        ]);
        Location::create($validate);
        if ($request->ajax()) {
            return response()->json(['success' => 'Berhasil menambah data!']);
        }
        return redirect('/location')->with('success', 'Berhasil menambah data!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Location $location) {
        return redirect()->away("https://www.google.com/maps?q={$location->latitude},{$location->longitude}");
    }

    public function showtrack(Location $location) {
        return view('pages.location.locationtrack', [
            'title' => 'Tracking Lokasi Satpam',
            'location' => $location,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Location $location) {
        return response()->json([
            'id' => $location->id,
            'location_name' => $location->location_name,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Location $location) {
        $validate = $request->validate([
            'location_name' => 'required|unique:locations',
        ],[
            'location_name.required' => 'Nama Lokasi harus diisi.',
            'location_name.unique' => 'Nama Lokasi sudah ada.'
        ]);
        $location->update($validate);
        if ($request->ajax()) {
            return response()->json(['success' => 'Berhasil mengubah data!']);
        }
        return redirect('/location')->with('success', 'Berhasil mengubah data!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Location $location) {
        Location::destroy($location->id);
        return redirect('/location')->with('success', 'Berhasil menghapus data!');
    }
}
