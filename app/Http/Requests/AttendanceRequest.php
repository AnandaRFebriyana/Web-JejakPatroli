<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AttendanceRequest extends FormRequest {
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
            'date' => 'required|date',
            'shift_id' => 'required',
            'guard_id' => 'required',
        ];
    }

    public function messages(): array {
        return [
            'date.required' => 'Tanggal harus diisi.',
            'date.date' => 'Format tanggal tidak valid.',
            'shift_id.required' => 'Pilih shift terlebih dahulu.',
            'guard_id.required' => 'Pilih satpam terlebih dahulu.',
        ];
    }
}
