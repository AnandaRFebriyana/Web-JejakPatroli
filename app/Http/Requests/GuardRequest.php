<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class GuardRequest extends FormRequest {
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array {
        return [
            'name' => 'required',
            'birth_date' => 'required',
            'photo' => 'image|mimes:jpeg,png,jpg|max:10240',
            'email' => 'required|email|unique:guards,email',
            'password' => 'required|confirmed|min:6|regex:/^(?=.*[0-9])(?=.*[!@#$%^&*])[a-zA-Z0-9!@#$%^&*]+$/',
            'phone_number' => 'required|min:11|max:15|regex:/^[0-9]+$/',
            'address' => 'required',
        ];
    }

    public function messages(): array {
        return [
            'name.required' => 'Nama harus diisi',
            'birth_date.required' => 'Tanggal Lahir harus diisi',
            'email.required' => 'Email harus diisi',
            'email.email' => 'Format Email tidak valid',
            'email.unique' => 'Email sudah digunakan',
            'password.required' => 'Password harus diisi',
            'password.min' => 'Password harus memiliki minimal 6 karakter',
            'password.regex' => 'Password harus mengandung angka dan simbol (contoh simbol: !@#$%^&*)',
            'password.confirmed' => 'Konfirmasi password tidak cocok',
            'phone_number.required' => 'Nomor Telepon harus diisi',
            'phone_number.min' => 'Nomor Telepon harus memiliki minimal 11 digit',
            'phone_number.max' => 'Nomor Telepon maksimal 15 digit',
            'phone_number.regex' => 'Nomor Telepon hanya boleh berisi angka',
            'address.required' => 'Alamat harus diisi',
        ];
    }
}
