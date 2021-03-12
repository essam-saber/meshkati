<?php

namespace Database\Factories;

use App\Sale;
use App\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class SaleFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Sale::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'year' => $this->faker->year,
            'month' => $this->faker->month,
            'cash' => $this->faker->numberBetween(10000,100000),
            'debit' => $this->faker->numberBetween(1, 1000),
            'returns' => $this->faker->numberBetween(1, 100),
            'user_id' => User::factory()->create()->id,
        ];
    }
}
