<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Donation>
 */
class DonationFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            //
            'name' => $this->faker->username(),
            'amount' => $this->faker->numberBetween(100, 10000), 
            'currency' => $this->faker->currencyCode(),
            'message' => $this->faker->sentence(),
            'read' => false,
            'event_time' => $this->faker->dateTimeBetween('-3 months', 'now'),
        ];
    }
}
