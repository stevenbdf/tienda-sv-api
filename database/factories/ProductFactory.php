<?php

namespace Database\Factories;

use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;

class ProductFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Product::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => $this->faker->text,
            'img' => $this->faker->imageUrl,
            'description' => $this->faker->text,
            'regular_price' => $this->faker->randomFloat(2, 0, 10000),
            'sale_price' => $this->faker->randomFloat(2, 0, 10000),
            'stock_qty' => $this->faker->randomNumber(2),
        ];
    }
}
