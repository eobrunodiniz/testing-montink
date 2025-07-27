<?php

namespace Database\Factories;

use App\Models\Coupon;
use Illuminate\Database\Eloquent\Factories\Factory;

class CouponFactory extends Factory
{
    protected $model = Coupon::class;

    public function definition()
    {
        return [
            'code' => strtoupper($this->faker->unique()->bothify('??###')),
            'discount_type' => $this->faker->randomElement(['percent', 'fixed']),
            'discount_value' => $this->faker->randomFloat(2, 5, 50),
            'min_subtotal' => $this->faker->randomFloat(2, 0, 200),
            'valid_from' => now()->subDays(1),
            'valid_to' => now()->addDays(10),
        ];
    }
}
