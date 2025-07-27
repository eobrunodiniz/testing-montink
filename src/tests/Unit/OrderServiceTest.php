<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Http;
use App\Services\OrderService;
use App\Models\Product;
use App\Models\Stock;
use App\Models\Coupon;
use App\Services\CartService;

class OrderServiceTest extends TestCase
{
    use RefreshDatabase;

    private CartService $cart;
    private OrderService $service;

    protected function setUp(): void
    {
        parent::setUp();

        $this->cart = $this->app->make(CartService::class);
        $this->app->instance(CartService::class, $this->cart);
        session()->forget(CartService::SESSION_KEY);

        $this->service = $this->app->make(OrderService::class);
    }

    public function test_place_order_calculations_and_stock_decrement()
    {
        $product = Product::factory()->create(['price' => 30.00]);

        Stock::factory()->create([
            'product_id' => $product->id,
            'variation' => 'G',
            'quantity'  => 100,
        ]);

        $coupon = Coupon::factory()->create([
            'discount_type' => 'percent',
            'discount_value' => 10,
            'min_subtotal'   => 5,
            'valid_from'     => now()->subDay(),
            'valid_to'       => now()->addDay(),
        ]);

        Http::fake([
            'viacep.com.br/*' => Http::response([], 200)
        ]);

        $address = [
            'cep',
            'street',
            'number',
            'complement',
            'district',
            'city',
            'state'
        ];

        $this->cart->add($product->id, 'G', 2);

        $addressData = array_combine($address, array_fill(0, count($address), 'X'));

        $order = $this->service->placeOrder($addressData, $coupon->code, 'bruno.diniz@montink.com.br');

        $this->assertEquals(60.00, $order->subtotal);
        $this->assertEquals(15.00, $order->shipping);
        $this->assertEquals(6.00, $order->discount);
        $this->assertEquals(69.00, $order->total);

        $this->assertDatabaseHas('stocks', [
            'product_id' => $product->id,
            'variation'  => 'G',
            'quantity'   => 98,
        ]);
    }
}
