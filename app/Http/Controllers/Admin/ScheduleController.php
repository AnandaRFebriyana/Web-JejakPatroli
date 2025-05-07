<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\ScheduleRequest;
use App\Http\Requests\ShiftRequest;
use App\Models\Guard;
use App\Models\Schedule;
use App\Models\Shift;
use Illuminate\Http\Request;

class ScheduleController extends Controller {

    public function index(Request $request) {
        $title = 'Delete!';
        $text = "Are you sure you want to delete?";
        confirmDelete($title, $text);
    
        // $guardId = $request->input('guard'); // sm kyk di urlnya
        
        // $schedules = Schedule::when($guardId,
        // function ($query) use ($guardId) {
        //     $query->where('guard_id', $guardId);
        // })->latest('id')->paginate(10);
        
        $day = $request->input('day');

        $schedules = Schedule::when($day,
        function ($query) use ($day) {
            $query->where('day', $day);
        })->latest('id')->paginate(10);

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
        $existingSchedule = Schedule::where('day', $validatedData['day'])
                            ->where(function ($query) use ($validatedData) {
                                $query->where('shift_id', $validatedData['shift_id'])
                                      ->orWhere('guard_id', $validatedData['guard_id']);
                            })->exists();

        if ($existingSchedule) {
            return redirect('/schedules')->with('info', 'Jadwal tersebut sudah tersedia.');
        }

        Schedule::create($validatedData);
        return redirect('/schedules')->with('success', 'Berhasil menambah data!');
    }

    public function editGuard($id) {
        return view('pages.schedule.edit', [
            'title' => 'Presensi',
            'schedule' => Schedule::find($id),
            'shifts' => Shift::all(),
            'guards' => Guard::all(),
        ]);
    }

    public function updateGuard(ScheduleRequest $request, $id) {
        $rules = $request->validated();
        $existingSchedule = Schedule::where('day', $rules['day'])
                            ->where(function ($query) use ($rules, $id) {
                                $query->where('shift_id', $rules['shift_id'])
                                      ->where('guard_id', $rules['guard_id'])
                                      ->where('id, '!=', $id')
                                      ->exists();
                            })
                            ->where('id', '!=', $id)
                            ->exists();

        if ($existingSchedule) {
            return redirect('/schedules')->with('info', 'Jadwal tersebut sudah tersedia.');
        }
    
        Schedule::where('id', $id)->update($rules);
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
        // dd($request->all());
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