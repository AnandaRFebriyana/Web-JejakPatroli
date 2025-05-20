<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ReportResource extends JsonResource {
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array {
        return [
            'id' => $this->id,
            'guard_id' => $this->guard_id,
            'status' => $this->status,
            'description' => $this->description,
            'attachment' => $this->attachment,
            'created_at' => $this->created_at
        ];
    }
}
