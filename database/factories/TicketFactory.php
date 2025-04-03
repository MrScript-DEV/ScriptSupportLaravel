<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class TicketFactory extends Factory
{
    public function definition(): array
    {
        return [
            'subject' => $this->faker->sentence(),
            'rating' => $this->faker->numberBetween(0,5),
        ];
    }
}
