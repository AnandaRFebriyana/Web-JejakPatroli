<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Report>
 */
class ReportFactory extends Factory {
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array {
        return [
            'guard_id' => $this->faker->numberBetween(1, 3),
            'location_id' => $this->faker->numberBetween(1, 4),
            'status' => 'Aman',
            'description' => $this->faker->sentence,
            'attachment' => $this->faker->imageUrl(),
        ];
    }
}
