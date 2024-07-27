<?php

namespace Database\Factories;

use App\Models\Player;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Player>
 */
class PlayerFactory extends Factory
{
    protected $model = Player::class;
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'player_name' => fake()->name(),
            'games' => fake()->numberBetween(1, 100),
            'wins' => fake()->numberBetween(1, 100),
            'deaths' => fake()->numberBetween(1, 100),
            'best' => fake()->numberBetween(1, 100),
            'average' => fake()->numberBetween(1, 100),
            'totalgold' => fake()->numberBetween(1, 100),
            'art5' => fake()->numberBetween(1, 100),
            'art7' => fake()->numberBetween(1, 100),
            'art10' => fake()->numberBetween(1, 100),
            'art12' => fake()->numberBetween(1, 100),
            'art15' => fake()->numberBetween(1, 100),
            'art17' => fake()->numberBetween(1, 100),
            'art20' => fake()->numberBetween(1, 100),
            'art25' => fake()->numberBetween(1, 100),
            'art30' => fake()->numberBetween(1, 100)
        ];
    }
}
