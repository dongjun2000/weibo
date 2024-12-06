<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Status>
 */
class StatusFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        $data_time = $this->faker->date . ' ' . $this->faker->time;
        return [
            'user_id' => $this->faker->randomElement(['1', '2', '3', '4', '5']),
            'content' => $this->faker->text(),
            'created_at' => $data_time,
            'updated_at' => $data_time,
        ];
    }
}
