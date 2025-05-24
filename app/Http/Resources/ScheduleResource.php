<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;


class ScheduleResource extends JsonResource {
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array {
        return [
            // 'id' => $this->id,
            // 'guard_id' => $this->guard_id,
            // 'shift_id' => $this->shift_id,
            // 'day' => $this->day,
            // 'guardRelation' => [
            //     'id' => $this->guardRelation->id,
            //     'name' => $this->guardRelation->name,
            // ],
            // 'shift' => [
            //     'id' => $this->shift->id,
            //     'start_time' => $this->shift->start_time,
            //     'end_time' => $this->shift->end_time
            // ],

            'id' => $this->id,
            'guard_id' => $this->guard_id,
            'name' => $this->guardRelation->name,
            'day' => $this->day,
            'start_time' => $this->shift->start_time,
            'end_time' => $this->shift->end_time,
            'schedule_date' => $this->schedule_date,
        ];
    }
}
