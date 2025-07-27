<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Stock;
use App\Models\Product;

class StockFactory extends Factory
{
    protected $model = Stock::class;

    public function definition()
    {
        return [
            'product_id' => Product::factory(),
            'variation' => $this->faker->randomElement(['P', 'M', 'G', 'U']),
            'quantity'  => $this->faker->numberBetween(1, 20),
        ];
    }
}
