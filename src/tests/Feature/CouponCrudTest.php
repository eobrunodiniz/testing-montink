<?php

namespace Tests\Feature;

use App\Models\Coupon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CouponCrudTest extends TestCase
{
    use RefreshDatabase;

    public function test_index_shows_cupons()
    {
        $coupon = Coupon::factory()->create();
        $response = $this->get(route('coupons.index'));
        $response->assertStatus(200);
        $response->assertSee($coupon->code);
    }

    public function test_store_validates_and_creates_coupon()
    {
        $payload = [
            'code' => 'ABC123',
            'discount_type' => 'percent',
            'discount_value' => 10,
            'min_subtotal' => 50,
            'valid_from' => now()->format('Y-m-d'),
            'valid_to' => now()->addDays(5)->format('Y-m-d'),
        ];

        $response = $this->post(route('coupons.store'), $payload);
        $response->assertRedirect(route('coupons.index'));
        $this->assertDatabaseHas('coupons', [
            'code' => 'ABC123',
            'discount_type' => 'percent',
            'discount_value' => 10.00,
            'min_subtotal' => 50.00,
        ]);
    }

    public function test_update_coupon()
    {
        $coupon = Coupon::factory()->create([
            'code' => 'OLD100',
            'discount_value' => 5,
        ]);

        $payload = [
            'code' => 'NEW200',
            'discount_type' => 'fixed',
            'discount_value' => 20,
            'min_subtotal' => 0,
            'valid_from' => now()->subDays(2)->format('Y-m-d'),
            'valid_to' => now()->addDays(3)->format('Y-m-d'),
        ];

        $response = $this->put(route('coupons.update', $coupon->id), $payload);
        $response->assertRedirect(route('coupons.index'));
        $this->assertDatabaseHas('coupons', [
            'id' => $coupon->id,
            'code' => 'NEW200',
            'discount_type' => 'fixed',
            'discount_value' => 20.00,
        ]);
    }

    public function test_delete_coupon()
    {
        $coupon = Coupon::factory()->create();
        $response = $this->delete(route('coupons.destroy', $coupon->id));
        $response->assertRedirect(route('coupons.index'));
        $this->assertDatabaseMissing('coupons', ['id' => $coupon->id]);
    }
}
