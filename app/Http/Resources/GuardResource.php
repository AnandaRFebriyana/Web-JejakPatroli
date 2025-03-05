<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class GuardResource extends JsonResource {
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'birth_date' => $this->birth_date,
            'email' => $this->email,
            'phone_number' => $this->phone_number,
            'address' => $this->address,
            'photo' => $this->photo,
            'token' => $this->whenNotNull($this->token)
        ];
    }
}
