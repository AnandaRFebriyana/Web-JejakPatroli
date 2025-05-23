<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ScheduleRequest extends FormRequest {
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
        // Jika ada start_date dan end_date, berarti ini adalah pembuatan jadwal baru
        if ($this->has('start_date') && $this->has('end_date')) {
            return [
                'guard_id' => 'required',
                'shift_id' => 'required',
                'start_date' => 'required|date',
                'end_date' => 'required|date|after_or_equal:start_date',
            ];
        }

        // Jika ada schedule_date, berarti ini adalah update jadwal
        return [
            'guard_id' => 'required',
            'shift_id' => 'required',
            'day' => 'required',
            'schedule_date' => 'required|date',
        ];
    }

    public function messages(): array {
        return [
            'guard_id.required' => 'Nama Satpam harus diisi.',
            'shift_id.required' => 'Shift harus diis.',
            'day.required' => 'Hari harus diisi.',
            'schedule_date.required' => 'Tanggal jadwal harus diisi.',
            'schedule_date.date' => 'Format tanggal tidak valid.',
            'start_date.required' => 'Tanggal mulai harus diisi.',
            'end_date.required' => 'Tanggal selesai harus diisi.',
            'end_date.after_or_equal' => 'Tanggal selesai harus sama dengan atau setelah tanggal mulai.'
        ];
    }
}
