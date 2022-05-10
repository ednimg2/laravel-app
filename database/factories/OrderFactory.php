<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Model>
 */
class OrderFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        $paymentMethod = ['paysera', 'paypal', 'stripe'];
        $deliveryMethod = ['dpd', 'dhl', 'tnt', 'schenker', 'venipak'];
        $countryId = [68, 120, 126, 84, 231, 175, 81, 74];

        return [
            'status' => $this->faker->numberBetween(0, 2),
            'user_id' => null,
            'first_name' => $this->faker->firstName(),
            'last_name' => $this->faker->lastName(),
            'email' => $this->faker->safeEmail(),
            'phone' => $this->faker->phoneNumber(),
            'payment_method' => $paymentMethod[array_rand($paymentMethod)],
            'delivery_method' => $deliveryMethod[array_rand($deliveryMethod)],
            'delivery_country_id' => $countryId[array_rand($countryId)],
            'delivery_city' => $this->faker->city(),
            'delivery_address' => $this->faker->streetAddress(),
            'created_at' => $this->faker->dateTimeBetween('-5 week', '+1 hours'),
        ];
    }
}
