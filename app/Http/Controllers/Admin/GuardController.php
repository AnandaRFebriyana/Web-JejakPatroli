<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\GuardRequest;
use App\Models\Guard;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class GuardController extends Controller {
    /**
     * Display a listing of the resource.
     */
    public function index() {
        $title = 'Hapus!';
        $text = "Apakah anda yakin ingin menghapusnya?";
        confirmDelete($title, $text);

        $guards = Guard::paginate(5);
        return view('pages.guard.guard', compact('guards'), [
            'title' => 'Data Satpam'
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create() {
        return view('pages.guard.create', [
            'title' => 'Data Satpam'
        ]);
    }

    public function getPhoto($id) {
        $guard = Guard::find($id);

        if (!$guard || !$guard->photo) {
            return response()->json([
                'error' => 'Data tidak ditemukan atau tidak memiliki foto.'
            ], 404);
        }

        $photoUrl = url('storage/' . $guard->photo);

        return response()->json([
            'photo_url' => $photoUrl
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(GuardRequest $request) {
        $validatedData = $request->validated();
        $validatedData['password'] = Hash::make($validatedData['password']);

        if ($request->hasFile('photo')) {
            $validatedData['photo'] = $request->file('photo')->store('photo-profile', 'public');
        }

        Guard::create($validatedData);
        return redirect('/guard')->with('success','Berhasil menambah data!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Guard $guard) {

    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Guard $guard) {
        return view('pages.guard.edit', [
            'title' => 'Data Satpam',
            'guard' => $guard
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Guard $guard) {
        $rules = [
            'name' => 'required',
            'birth_date' => 'required',
            'photo' => 'image|mimes:jpeg,png,jpg|max:1024',
            'phone_number' => 'required',
            'address' => 'required',
        ];
        $validatedData = $request->validate($rules);

        if ($request->file('photo')) {
            if ($guard->photo) {
                Storage::delete($guard->photo);
            }
            $validatedData['photo'] = $request->file('photo')->store('photo-profile', 'public');
        }
        $guard->update($validatedData);

        // session()->flash('toast_message', 'Data has been updated!');
        // return redirect('/guard');
        // return redirect('/guard')->with('toast_success','Data has been updated!');
        return redirect('/guard')->with('success','Berhasil mengubah data!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Guard $guard) {
        Guard::destroy($guard->id);
        // return redirect('/guard')->with('toast_success','Data has been deleted!');
        return redirect('/guard')->with('success','Berhasil menghapus data!');
    }

    public function getAccount($id) {
        $guard = Guard::find($id);
        return response()->json([
            'id' => $guard->id,
            'email' => $guard->email,
        ]);
    }

    public function updatePass(Request $request, $id) {
        $guard = Guard::find($id);

        $rules = [
            'password' => 'required|confirmed|min:6|regex:/^(?=.*[0-9])(?=.*[!@#$%^&*])[a-zA-Z0-9!@#$%^&*]+$/',
        ];

        $validatedData = $request->validate($rules, [
            'password.required' => 'Password harus di isi',
            'password.min' => 'Password harus memiliki minimal :min karakter.',
            'password.regex' => 'Password harus mengandung setidaknya satu angka dan satu simbol.',
            'password.confirmed' => 'Konfirmasi password tidak cocok.',
        ]);

        if ($request->filled('password')) {
            $validatedData['password'] = Hash::make($validatedData['password']);
            $guard->update(['password' => $validatedData['password']]);

            if ($request->ajax()) {
                return response()->json(['success' => 'Berhasil mengubah password!']);
            }
            return redirect('/guard')->with('success', 'Berhasil mengubah password!');
        } else {
            return redirect('/guard')->with('error', 'Password tidak diisi!');
        }
    }



}
