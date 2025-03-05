<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ShiftRequest extends FormRequest {
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
            'shift_name' => 'required',
            'start_time' => 'required',
            'end_time' => 'required',
        ];
    }

    public function messages(): array {
        return [
            'shift_name.required' => 'Nama Shift harus diisi.',
            'start_time.required' => 'Waktu Mulai harus diisi.',
            'end_time.required' => 'Waktu Selesai harus diisi.'
        ];
    }
}
