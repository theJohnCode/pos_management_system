<?php

namespace Database\Factories;

use App\Models\Customer;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Order>
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
        return [
            'customer_id' => Customer::all()->random()->id,
            'total_amount' => $this->faker->unique()->numberBetween(100,2000),
            'discount' => $this->faker->unique()->numberBetween(1,20),
            'payment_method' => $this->faker->randomElement(['cash','card','transfer','cheque']),
            'order_status' => $this->faker->randomElement(['successful','pending','failed']),
            'cashier_name' => $this->faker->name
        ];
    }
}
