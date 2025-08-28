<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class EventFactory extends Factory
{
    public function definition(): array
    {
        return [
            'title' => $this->faker->sentence(3),
            'date' => $this->faker->dateTimeBetween('+1 days', '+1 month'),
            'capacity' => $this->faker->numberBetween(10, 100),
        ];
    }
}
