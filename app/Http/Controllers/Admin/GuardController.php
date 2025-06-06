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
    public function index(Request $request) {
        $title = 'Hapus!';
        $text = "Apakah anda yakin ingin menghapusnya?";
        confirmDelete($title, $text);

        $search = $request->input('search');
        $guards = Guard::when($search, function($query) use ($search) {
            $query->where('name', 'like', '%' . $search . '%')
                  ->orWhere('email', 'like', '%' . $search . '%')
                  ->orWhere('phone_number', 'like', '%' . $search . '%')
                  ->orWhere('address', 'like', '%' . $search . '%');
        })->paginate(5);

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

        // if ($request->hasFile('photo')) {
        //     $validatedData['photo'] = $request->file('photo')->store('photo-profile', 'public');
        // }
        if ($request->hasFile('photo')) {
            $photo = $request->file('photo');
            $filename = uniqid() . '.' . $photo->getClientOriginalExtension();
            $photo->move(public_path('storage/photo-profile'), $filename);
            $validatedData['photo'] = 'photo-profile/' . $filename;
        }


        Guard::create($validatedData);
        return redirect('/guard')->with('success','Berhasil menambah data!');
    }

    /**
     * Display the specified resource.

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
            'phone_number' => 'required|min:11|max:15|regex:/^[0-9]+$/',
            'address' => 'required',
        ];
        $validatedData = $request->validate($rules, [
            'name.required' => 'Nama harus diisi',
            'birth_date.required' => 'Tanggal Lahir harus diisi',
            'phone_number.required' => 'Nomor Telepon harus diisi',
            'phone_number.min' => 'Nomor Telepon harus memiliki minimal 10 digit',
            'phone_number.max' => 'Nomor Telepon maksimal 13 digit',
            'phone_number.regex' => 'Nomor Telepon hanya boleh berisi angka',
            'address.required' => 'Alamat harus diisi',
        ]);

        // if ($request->file('photo')) {
        //     if ($guard->photo) {
        //         Storage::delete($guard->photo);
        //     }
        //     $validatedData['photo'] = $request->file('photo')->store('photo-profile', 'public');
        // }
        if ($request->file('photo')) {
            if ($guard->photo && file_exists(public_path('storage/' . $guard->photo))) {
                unlink(public_path('storage/' . $guard->photo));
            }

            $photo = $request->file('photo');
            $filename = uniqid() . '.' . $photo->getClientOriginalExtension();
            $photo->move(public_path('storage/photo-profile'), $filename);
            $validatedData['photo'] = 'photo-profile/' . $filename;
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

    public function destroy($id) {
        $guard = Guard::find($id);
        $guard->delete();
        return back()->with('success', 'Berhasil mengahapus data!');

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
            'password.regex' => 'Password harus mengandung angka dan simbol (contoh simbol: !@#$%^&*).',
            'password.confirmed' => 'Konfirmasi password tidak cocok.',
        ]);

        if ($request->filled('password')) {
            // Cek apakah password baru sama dengan password lama
            if (Hash::check($request->password, $guard->password)) {
                if ($request->ajax()) {
                    return response()->json(['error' => 'Password baru tidak boleh sama dengan password lama.'], 422);
                }
                return redirect('/guard')->with('error', 'Password baru tidak boleh sama dengan password lama.');
            }

            $validatedData['password'] = Hash::make($validatedData['password']);
            $guard->update(['password' => $validatedData['password']]);

            if ($request->ajax()) {
                return response()->json(['success' => 'Berhasil mengubah password!']);
            }
            return redirect('/guard')->with('success', 'Berhasil mengubah password!');
        } else {
            if ($request->ajax()) {
                return response()->json(['error' => 'Password tidak diisi!'], 422);
            }
            return redirect('/guard')->with('error', 'Password tidak diisi!');
        }
    }



}
