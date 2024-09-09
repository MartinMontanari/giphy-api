<?php

namespace Database\Factories;

use App\domain\Models\Favorite;
use Illuminate\Database\Eloquent\Factories\Factory;


class FavoriteFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Favorite::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id' => $this->faker->numberBetween(1, 100),
            'gif_id' => $this->faker->numberBetween(1, 1000),
            'alias' => $this->faker->unique()->word(),
        ];
    }
}
