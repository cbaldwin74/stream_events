<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\MerchSale>
 */
class MerchSaleFactory extends Factory
{
    private const ITEMS = ['hat', 'shirt', 'mouse pad', 'watter bottle'];

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->username(),
            'item' => self::ITEMS[rand(0, count(self::ITEMS) - 1)],
            'count' => rand(1, 10),
            'price' => $this->faker->numberBetween(1000, 10000), 
            'currency' => 'CAD',
            'read' => false,
            'event_time' => $this->faker->dateTimeBetween('-3 months', 'now'),
        ];
    }
}
