<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class TicketFactory extends Factory
{
    public function definition(): array
    {
        return [
            'subject' => fake()->sentence(),
            'rating' => fake()->numberBetween(0,5),
        ];
    }
}
