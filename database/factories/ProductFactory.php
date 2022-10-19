<?php

namespace Database\Factories;

use App\Models\Brand;
use App\Models\Category;
use Picqer\Barcode\BarcodeGeneratorPNG;
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
        $product_code = rand(100000, 9000000);

        $generator = new BarcodeGeneratorPNG();
        $barCode = '<img src="data:image/png;base64,' . base64_encode($generator->getBarcode($product_code, $generator::TYPE_CODE_128,2,80)) . '">';
        // $generator = new BarcodeGeneratorPNG();

        return [
            'name' => $this->faker->unique()->name,
            'category_id' => Category::all()->random()->id,
            'brand_id' => Brand::all()->random()->id,
            'description' => $this->faker->sentences(20, true),
            'quantity' => $this->faker->numberBetween(1, 50),
            'product_code' => $product_code,
            'bar_code' => $barCode,
            'price' => $this->faker->randomFloat(2, 2, 100),
            'tax' => $this->faker->numberBetween(1, 10),
            'status' => $this->faker->randomElement([true, false]),
        ];
    }
}
