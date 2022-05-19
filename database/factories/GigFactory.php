<?php

namespace Database\Factories;

use App\Models\Company;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Gig>
 */
class GigFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'company_id' => Company::query()->first()->id,
            'name' => $this->faker->jobTitle(),
            'description' => $this->faker->text(),
            'start_time' => $this->faker->dateTimeBetween('-2 days', '+2 days'),
            'end_time' => $this->faker->dateTimeBetween('+3 days', '+10 days'),
            'number_of_positions' => $this->faker->numberBetween(1, 10),
            'pay_per_hour' => $this->faker->numberBetween(5, 50),
            'status' => $this->faker->boolean()
        ];
    }
}
