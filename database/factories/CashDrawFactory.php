<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\CashDraw>
 */
class CashDrawFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'title' => fake()->sentence(3),
            'description' => fake()->paragraph(3),
            'prize_amount' => fake()->numberBetween(100, 10000),
            'entry_fee' => fake()->numberBetween(10, 100),
            'draw_date' => fake()->dateTimeBetween('-1 week', '+1 week'),
            'status' => fake()->randomElement(['active', 'inactive', 'completed']),
        ];
    }
}
