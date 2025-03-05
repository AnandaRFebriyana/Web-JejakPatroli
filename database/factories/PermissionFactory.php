<?php

namespace Database\Factories;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Permission>
 */
class PermissionFactory extends Factory {
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array {
        $reasons = ['Cuti', 'Acara Keluarga', 'Sakit'];
        $permissionDate = $this->faker->dateTimeBetween('2024-03-01', Carbon::yesterday())->format('Y-m-d');
        $reason = $this->faker->randomElement($reasons);

        return [
            'guard_id' => $this->faker->numberBetween(1, 3),
            'permission_date' => $permissionDate,
            'reason' => $reason,
        ];
    }
}
