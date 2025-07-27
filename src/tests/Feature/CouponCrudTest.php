<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\Coupon;

class CouponCrudTest extends TestCase
{
    use RefreshDatabase;

    public function testIndexShowsCupons()
    {
        $coupon = Coupon::factory()->create();
        $response = $this->get(route('coupons.index'));
        $response->assertStatus(200);
        $response->assertSee($coupon->code);
    }

    public function testStoreValidatesAndCreatesCoupon()
    {
        $payload = [
            'code'           => 'ABC123',
            'discount_type'  => 'percent',
            'discount_value' => 10,
            'min_subtotal'   => 50,
            'valid_from'     => now()->format('Y-m-d'),
            'valid_to'       => now()->addDays(5)->format('Y-m-d'),
        ];

        $response = $this->post(route('coupons.store'), $payload);
        $response->assertRedirect(route('coupons.index'));
        $this->assertDatabaseHas('coupons', [
            'code'          => 'ABC123',
            'discount_type' => 'percent',
            'discount_value' => 10.00,
            'min_subtotal'  => 50.00,
        ]);
    }

    public function testUpdateCoupon()
    {
        $coupon = Coupon::factory()->create([
            'code' => 'OLD100',
            'discount_value' => 5,
        ]);

        $payload = [
            'code'           => 'NEW200',
            'discount_type'  => 'fixed',
            'discount_value' => 20,
            'min_subtotal'   => 0,
            'valid_from'     => now()->subDays(2)->format('Y-m-d'),
            'valid_to'       => now()->addDays(3)->format('Y-m-d'),
        ];

        $response = $this->put(route('coupons.update', $coupon->id), $payload);
        $response->assertRedirect(route('coupons.index'));
        $this->assertDatabaseHas('coupons', [
            'id'             => $coupon->id,
            'code'           => 'NEW200',
            'discount_type'  => 'fixed',
            'discount_value' => 20.00,
        ]);
    }

    public function testDeleteCoupon()
    {
        $coupon = Coupon::factory()->create();
        $response = $this->delete(route('coupons.destroy', $coupon->id));
        $response->assertRedirect(route('coupons.index'));
        $this->assertDatabaseMissing('coupons', ['id' => $coupon->id]);
    }
}
