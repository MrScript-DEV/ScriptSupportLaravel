<?php

namespace Database\Factories;

use Exception;
use Illuminate\Database\Eloquent\Factories\Factory;

class PriorityFactory extends Factory
{

    public function definition(): array
    {
        return [
            'name' => fake()->unique()->word(),
            'level' => fake()->unique()->numberBetween(0, 10),
        ];
    }
}
