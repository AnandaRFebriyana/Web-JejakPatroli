<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\ReportResource;
use App\Models\Report;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReportController extends Controller {

    public function getAll() {
        $guardId = Auth::guard('guard')->id();
        $report = Report::where('guard_id', $guardId)->orderBy('created_at', 'desc')->get();
        return ReportResource::collection($report);
    }

    public function hasReportedToday() {
        $attendedToday = AttendanceController::hasAttendedToday();

        if ($attendedToday) {
            $guardId = Auth::guard('guard')->id();
            $today = Carbon::today();

            $report = Report::where('guard_id', $guardId)
                ->whereDate('created_at', $today)
                ->first();

            return response()->json(['reported_today' => !is_null($report)]);
        } else {
            return response()->json(['reported_today' => true]);
        }
    }

    public function postReport(Request $request) {
        $validated = $request->validate([
            // 'location_id' => 'required', // HAPUS jika tidak perlu
            'status' => 'required',
            'description' => 'required|string|max:200',
            'attachment.*' => 'file|mimes:jpeg,png,jpg,mp4,mov,avi|max:10240', // 10MB, gambar/video
        ]);
        $validated['guard_id'] = Auth::guard('guard')->id();

        if ($request->hasFile('attachment')) {
            $attachments = [];
            foreach ($request->file('attachment') as $file) {
                // Generate nama file yang unik
                $filename = uniqid() . '.' . $file->getClientOriginalExtension();
                // Simpan file dengan nama yang unik
                $path = $file->storeAs('report-attachments', $filename, 'public');
                $attachments[] = $path;
            }
            $validated['attachment'] = json_encode($attachments);
        }
        $report = Report::create($validated);

        return response()->json([
            'message' => 'Report created successfully',
            'data' => new ReportResource($report)
        ], 201);
    }
}
