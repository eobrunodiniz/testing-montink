<?php

namespace Database\Factories;

use App\Models\Product;
use App\Models\Stock;
use Illuminate\Database\Eloquent\Factories\Factory;

class StockFactory extends Factory
{
    protected $model = Stock::class;

    public function definition()
    {
        return [
            'product_id' => Product::factory(),
            'variation' => $this->faker->randomElement(['P', 'M', 'G', 'U']),
            'quantity' => $this->faker->numberBetween(1, 20),
        ];
    }
}
