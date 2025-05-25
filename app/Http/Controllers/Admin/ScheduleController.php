<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\ScheduleRequest;
use App\Http\Requests\ShiftRequest;
use App\Models\Guard;
use App\Models\Schedule;
use App\Models\Shift;
use App\Models\Attendance;
use Illuminate\Http\Request;
use Carbon\Carbon;

class ScheduleController extends Controller {

    public function index(Request $request) {
        $title = 'Delete!';
        $text = "Are you sure you want to delete?";
        confirmDelete($title, $text);

        $day = $request->input('day');
        $today = Carbon::today()->format('Y-m-d');

        $schedules = Schedule::query()
            ->join('shifts', 'schedules.shift_id', '=', 'shifts.id')
            ->where('schedule_date', '>=', $today)
            ->when($day,
                function ($query) use ($day) {
                    $query->where('day', $day);
                })
            ->orderBy('schedule_date', 'asc')
            ->orderByRaw("FIELD(day, 'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu', 'Minggu')")
            ->orderBy('shifts.start_time', 'asc')
            ->select('schedules.*')
            ->paginate(10);

        return view('pages.schedule.schedule', [
            'title' => 'Data Jadwal',
            'shifts'=> Shift::all(),
            'guards' => Guard::all(),
            'schedules' => $schedules
        ]);
    }

    public function createGuard() {
        return view('pages.schedule.insert', [
            'title' => 'Data Jadwal',
            'guards' => Guard::all(),
            'shifts' => Shift::all()
        ]);
    }

    public function storeGuard(ScheduleRequest $request) {
        $validatedData = $request->validated();

        // Get start and end dates
        $startDate = Carbon::parse($validatedData['start_date']);
        $endDate = Carbon::parse($validatedData['end_date']);

        // Array untuk mapping hari dalam bahasa Indonesia
        $days = ['Minggu', 'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu'];

        // Check for existing schedules in the date range
        $currentDate = $startDate->copy();
        while ($currentDate <= $endDate) {
            $dayName = $days[$currentDate->dayOfWeek];

            $existingSchedule = Schedule::where('day', $dayName)
                ->where('schedule_date', $currentDate->format('Y-m-d'))
                ->where(function ($query) use ($validatedData) {
                    $query->where('shift_id', $validatedData['shift_id'])
                          ->orWhere('guard_id', $validatedData['guard_id']);
                })->exists();

            if ($existingSchedule) {
                return redirect('/schedules')->with('info', "Jadwal untuk hari {$dayName} tanggal {$currentDate->format('d/m/Y')} sudah tersedia.");
            }

            $currentDate->addDay();
        }

        // Create schedules for each day in the range
        $currentDate = $startDate->copy();
        while ($currentDate <= $endDate) {
            $dayName = $days[$currentDate->dayOfWeek];

            $schedule = Schedule::create([
                'guard_id' => $validatedData['guard_id'],
                'shift_id' => $validatedData['shift_id'],
                'day' => $dayName,
                'schedule_date' => $currentDate->format('Y-m-d')
            ]);

            // Create attendance record for this schedule
            Attendance::create([
                'guard_id' => $validatedData['guard_id'],
                'shift_id' => $validatedData['shift_id'],
                'date' => $currentDate->format('Y-m-d'),
                'status' => 'Tidak Hadir'
            ]);

            $currentDate->addDay();
        }

        return redirect('/schedules')->with('success', 'Berhasil menambah data jadwal!');
    }

    public function editGuard($id) {
        return view('pages.schedule.edit', [
            'title' => 'Jadwal',
            'schedule' => Schedule::find($id),
            'shifts' => Shift::all(),
            'guards' => Guard::all(),
        ]);
    }

    public function updateGuard(ScheduleRequest $request, $id) {
        $validatedData = $request->validated();
        $schedule = Schedule::findOrFail($id);

        // Check for existing schedules on the same day and date
        $existingSchedule = Schedule::where('day', $validatedData['day'])
            ->where('schedule_date', $validatedData['schedule_date'])
            ->where(function ($query) use ($validatedData, $id) {
                $query->where('shift_id', $validatedData['shift_id'])
                      ->where('guard_id', $validatedData['guard_id'])
                      ->where('id', '!=', $id);
            })->exists();

        if ($existingSchedule) {
            return redirect('/schedules')->with('info', 'Jadwal tersebut sudah tersedia pada hari dan tanggal yang sama.');
        }

        $schedule->update($validatedData);
        return redirect('/schedules')->with('success', 'Berhasil mengubah data!');
    }

    public function destroyGuard($id) {
        $schedule = Schedule::find($id);
        $schedule->delete();
        return back()->with('success', 'Berhasil mengahapus data!');
    }

    public function createShift() {
        return view('pages.schedule.insert',
        [
            'title' => 'Data Jadwal'
        ]);
    }

    public function storeShift(ShiftRequest $request) {
        $validatedData = $request->validated();
        Shift::create($validatedData);
        if ($request->ajax()) {
            return response()->json(['success' => 'Berhasil menambah data!']);
        }
        return redirect('/schedules')->with('success', 'Berhasil menambah data!');
    }

    public function editShift($id) {
        $shift = Shift::find($id);
        return response()->json([
            'id' => $shift->id,
            'shift_name' => $shift->shift_name,
            'start_time' => $shift->start_time,
            'end_time' => $shift->end_time,
        ]);
    }

    public function updateShift(ShiftRequest $request, $id) {
        $validatedData = $request->validated();
        $shift = Shift::findOrFail($id);
        $shift->update($validatedData);
        if ($request->ajax()) {
            return response()->json(['success' => 'Berhasil mengubah data!']);
        }
        return redirect('/schedules')->with('success', 'Berhasil mengubah data!');
    }

    public function destroyShift($id) {
        $shift = Shift::find($id);
        $shift->delete();
        return back()->with('success', 'Berhasil menghapus data!');
    }
}
