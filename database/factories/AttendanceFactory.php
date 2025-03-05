<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Attendance>
 */
class AttendanceFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array {
        $checkInTime = $this->faker->optional()->time('H:i:s');
        $checkOutTime = $this->faker->optional()->time('H:i:s');
        
        $status = null;
        if ($checkInTime && $checkOutTime) {
            $status = 'Hadir';
        } elseif (!$checkInTime && !$checkOutTime) {
            $status = null;
        }
        
        $date = $this->faker->dateTimeBetween('2024-03-01', '2024-07-10')->format('Y-m-d');
        return [
            'shift_id' => $this->faker->numberBetween(1, 3),
            'guard_id' => $this->faker->numberBetween(1, 3),
            'date' => $date,
            'check_in_time' => $checkInTime,
            'check_out_time' => $checkOutTime,
            'status' => $status
        ];        
    }
}
