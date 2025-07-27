<?php

namespace Tests\Feature;

use App\Models\Product;
use App\Models\Stock;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CartTest extends TestCase
{
    use RefreshDatabase;

    public function test_add_item_to_cart_and_session()
    {
        $product = Product::factory()->create(['price' => 10]);
        Stock::factory()->create([
            'product_id' => $product->id,
            'variation' => 'P',
            'quantity' => 5,
        ]);

        $response = $this->post(route('cart.add'), [
            'product_id' => $product->id,
            'variation' => 'P',
            'qty' => 2,
        ]);

        $response->assertRedirect();
        $response->assertSessionHas('success', 'Item adicionado ao carrinho.');

        $cart = session('cart');
        $this->assertArrayHasKey("{$product->id}:P", $cart);
        $this->assertEquals(2, $cart["{$product->id}:P"]['qty']);
    }

    public function test_update_and_remove_item_in_cart()
    {
        $product = Product::factory()->create(['price' => 15]);
        Stock::factory()->create([
            'product_id' => $product->id,
            'variation' => 'M',
            'quantity' => 3,
        ]);

        session([
            'cart' => [
                "{$product->id}:M" => [
                    'product_id' => $product->id,
                    'name' => $product->name,
                    'variation' => 'M',
                    'price' => 15,
                    'qty' => 1,
                ],
            ],
        ]);

        $this->post(route('cart.update'), [
            'product_id' => $product->id,
            'variation' => 'M',
            'qty' => 3,
        ])->assertRedirect();

        $this->assertEquals(3, session('cart')["{$product->id}:M"]['qty']);

        $this->post(route('cart.remove'), [
            'product_id' => $product->id,
            'variation' => 'M',
        ])->assertRedirect()
            ->assertSessionHas('success', 'Item removido do carrinho.');

        $this->assertEmpty(session('cart'));
    }

    public function test_cart_index_displays_subtotal_shipping_and_total()
    {
        $product = Product::factory()->create(['price' => 100]);
        Stock::factory()->create([
            'product_id' => $product->id,
            'variation' => 'U',
            'quantity' => 10,
        ]);

        session([
            'cart' => [
                "{$product->id}:U" => [
                    'product_id' => $product->id,
                    'name' => $product->name,
                    'variation' => 'U',
                    'price' => 100,
                    'qty' => 3,
                ],
            ],
        ]);

        $response = $this->get(route('cart.index'));
        $response->assertStatus(200);
        $response->assertSeeText('Subtotal: R$ 300,00');
        $response->assertSeeText('Frete: R$ 0,00');
        $response->assertSeeText('Total: R$ 300,00');
    }
}
