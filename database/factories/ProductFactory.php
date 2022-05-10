<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Model>
 */
class ProductFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'name' => $this->faker->sentence(3),
            'sku' => $this->faker->bothify('??####'),
            'description' => $this->faker->text(100),
            'price' => $this->faker->randomFloat(2, 1, 99),
            'quantity' => $this->faker->numberBetween(0, 20),
            'status' => $this->faker->numberBetween(0, 1),
        ];
    }
}
