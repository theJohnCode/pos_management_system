<?php

namespace Database\Factories;

use App\Models\Brand;
use App\Models\Category;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Product>
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
            'name' => $this->faker->unique()->name,
            'category_id' => Category::all()->random()->id,
            'brand_id' => Brand::all()->random()->id,
            'description' => $this->faker->sentences(20,true),
            'quantity' => $this->faker->numberBetween(1,50),
            'price' => $this->faker->randomFloat(2, 2, 100),
            'tax' => $this->faker->numberBetween(1,10),
            'status' => $this->faker->randomElement([true, false]),
        ];
    }
}
