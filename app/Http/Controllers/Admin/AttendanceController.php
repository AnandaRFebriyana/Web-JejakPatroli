<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\AttendanceRequest;
use App\Models\Attendance;
use App\Models\Guard;
use App\Models\Schedule;
use App\Models\Shift;
use Carbon\Carbon;
use Illuminate\Http\Request;

class AttendanceController extends Controller {
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request) {
        $title = 'Delete!';
        $text = "Are you sure you want to delete?";
        confirmDelete($title, $text);

        $today = Carbon::today()->format('Y-m-d');
        $search = $request->input('search');

        $attendances = Attendance::query()
            ->join('shifts', 'attendances.shift_id', '=', 'shifts.id') // Join with shifts table
            ->join('guards', 'attendances.guard_id', '=', 'guards.id') // Join with guards table
            ->select('attendances.*', 'shifts.start_time', 'shifts.end_time', 'guards.name as guard_name') // Select necessary columns
            ->when($search,
                function ($query, $search) {
                    $query->where(function ($query) use ($search) {
                        $query->where('guards.name', 'like', '%' . $search . '%') // Search by guard name
                            ->orWhere('shifts.start_time', 'like', '%' . $search . '%') // Search by shift start time
                            ->orWhere('shifts.end_time', 'like', '%' . $search . '%') // Search by shift end time
                            ->orWhere(function ($query) use ($search) {
                                try {
                                    $date = Carbon::parse($search)->format('Y-m-d');
                                    $query->where('attendances.date', $date);
                                } catch (\Exception $e) {
                                    // If parsing fails, the date search condition is effectively skipped for this input
                                }
                            })
                            ->orWhere(function ($query) use ($search) {
                                $lowerSearch = strtolower($search);
                                $query->whereRaw('LOWER(attendances.status) LIKE ?', ['%' . $lowerSearch . '%']);
                            });
                    });
                })
            ->orderByRaw("CASE WHEN date >= ? THEN 0 ELSE 1 END, CASE WHEN date >= ? THEN date ELSE NULL END ASC, CASE WHEN date < ? THEN date ELSE NULL END DESC", [$today, $today, $today]) // Prioritize today/future (0) over past (1), sort future/today dates ASC, sort past dates DESC
            ->orderBy('shifts.start_time', 'asc') // Then sort by shift start time for both groups
            ->select('attendances.*') // Select only columns from attendances table
            ->paginate(8)->withQueryString(); // Add query string to pagination links

        return view('pages.presence.attendance', [
            'title' => 'Presensi',
            'attendances' => $attendances,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create() {
        return view('pages.presence.create', [
            'title' => 'Presensi',
            'guards' => Guard::all(),
            'shifts' => Shift::all()
        ]);
    }

    public function getSatpam(Request $request) {
        $day = $request->input('day');
        $shift = $request->input('shift');

        $guardOnShift = Schedule::where('day', $day)
                                ->where('shift_id', $shift)
                                ->with('guardRelation')
                                ->get()
                                ->map(function($schedule) {
                                    return [
                                        'id' => $schedule->guardRelation->id,
                                        'name' => $schedule->guardRelation->name,
                                    ];
                                });

        $allGuard = Guard::all();
        return response()->json([
            'guardOnShift' => $guardOnShift,
            'allGuard' => $allGuard
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(AttendanceRequest $request) {
        $validatedData = $request->validated();

        // Get start and end dates
        $startDate = Carbon::parse($validatedData['start_date']);
        $endDate = Carbon::parse($validatedData['end_date']);

        // Array untuk mapping hari dalam bahasa Indonesia
        $days = ['Minggu', 'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu'];

        // Check for existing attendances in the date range
        $currentDate = $startDate->copy();
        while ($currentDate <= $endDate) {
            $dayName = $days[$currentDate->dayOfWeek];

            $existingAttendance = Attendance::where('date', $currentDate->format('Y-m-d'))
                ->where('shift_id', $validatedData['shift_id'])
                ->where('guard_id', $validatedData['guard_id'])
                ->exists();

            if ($existingAttendance) {
                return redirect('/presence')->with('info', "Presensi untuk hari {$dayName} tanggal {$currentDate->format('d/m/Y')} sudah tersedia.");
            }

            $currentDate->addDay();
        }

        // Create attendances for each day in the range
        $currentDate = $startDate->copy();
        while ($currentDate <= $endDate) {
            Attendance::create([
                'guard_id' => $validatedData['guard_id'],
                'shift_id' => $validatedData['shift_id'],
                'date' => $currentDate->format('Y-m-d')
            ]);

            $currentDate->addDay();
        }

        return redirect('/presence')->with('success', 'Berhasil menambah data presensi!');
    }

    /**
     * Display the specified resource.
     */
    public function show($id) {
        $attendance = Attendance::findOrFail($id);

        return view('pages.presence.show', [
            'title' => 'Presensi',
            'attendance' => $attendance,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id) {
        $attendance = Attendance::findOrFail($id);
        return view('pages.presence.edit', [
            'title' => 'Presensi',
            'attendance' => $attendance,
            'shifts' => Shift::all(),
            'guards' => Guard::all(),
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id) {
        $rules = $request->validate([
            'date' => 'required',
            'shift_id' => 'required',
            'guard_id' => 'required'
        ]);

        Attendance::where('id', $id)->update($rules);
        return redirect('/presence')->with('success', 'Berhasil mengubah data!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id) {
        $attendance = Attendance::find($id);
        $attendance->delete();
        return redirect('/presence')->with('success', 'Berhasil mengahapus data!');
    }

    public function checkStatus($id) {
        $attendance = Attendance::find($id);
        $waktu_sekarang = Carbon::now()->format('H:i:s');
        $tanggal_sekarang = Carbon::today()->format('Y-m-d');
        // dd($waktu_sekarang, $tanggal_sekarang);
        $shift = Shift::find($attendance->shift_id);

        if (!$shift) {
            return response()->json(['error' => 'Shift tidak ditemukan'], 404);
        }

        $jam_kerja_selesai = $shift->end_time;
        if ($attendance->date > $tanggal_sekarang && !$attendance->check_in_time && !$attendance->check_out_time && $waktu_sekarang > $jam_kerja_selesai) {
            $attendance->status = 'Tidak Hadir';
        }
        $attendance->save();
    }
}
