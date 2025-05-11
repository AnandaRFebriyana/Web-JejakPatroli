<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\TrackingLog;

class TrackingLogController extends Controller
{
    public function index()
    {
        // Ambil semua tracking log, termasuk relasi guard dan schedules
        $logs = TrackingLog::with(['guardRelation.schedules'])->get();

        return view('pages.location.location', compact('logs'));
    }
}
