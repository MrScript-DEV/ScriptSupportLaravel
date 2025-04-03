<?php

namespace Database\Factories;

use Exception;
use Illuminate\Database\Eloquent\Factories\Factory;

class PriorityFactory extends Factory
{
    protected static $levels = [1, 2, 3];

    public function definition(): array
    {
        return [
            'name' => $this->faker->word(),
            'level' => function () {
                if (empty(static::$levels)) {
                    throw new Exception("Plus de niveaux disponibles !");
                }
                return array_shift(static::$levels);
            },
        ];
    }
}
