<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class AttendanceResource extends JsonResource {
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array {
        return [
            'id' => $this->id,
            'shift_id' => $this->shift_id,
            'start_time' => $this->shift->start_time,
            'end_time' => $this->shift->end_time,
            'guard_id' => $this->guard_id,
            'date' => $this->date->toDateString(),
            'check_in_time' => $this->check_in_time,
            'check_out_time' => $this->check_out_time,
            'status' => $this->status,
            'photo' => $this->photo,
            'longitude' => $this->longitude,
            'latitude' => $this->latitude,
            'location_address' => $this->location_address,
        ];
    }
}
