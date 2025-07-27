<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Services\CartService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\Product;    // ← importe aqui

class CartServiceTest extends TestCase
{
    use RefreshDatabase;

    private CartService $cart;

    protected function setUp(): void
    {
        parent::setUp();
        $this->cart = app(CartService::class);
    }

    public function test_subtotal_and_shipping_rules()
    {
        Product::factory()->create(['price' => 1]);

        // limpa e adiciona manualmente itens
        session()->forget(CartService::SESSION_KEY);

        // caso 1: subtotal 60 → frete R$15
        $this->cart->add(1, 'X', 60 / 1); // usando qty = subtotal
        $this->assertEquals(60, $this->cart->subtotal());
        $this->assertEquals(15.00, $this->cart->shipping());

        // limpa e testa subtotal < 52 → frete R$20
        session()->forget(CartService::SESSION_KEY);
        $this->cart->add(1, 'X', 40);
        $this->assertEquals(40, $this->cart->subtotal());
        $this->assertEquals(20.00, $this->cart->shipping());

        // limpa e testa subtotal > 200 → frete grátis
        session()->forget(CartService::SESSION_KEY);
        $this->cart->add(1, 'X', 201);
        $this->assertEquals(201, $this->cart->subtotal());
        $this->assertEquals(0.00, $this->cart->shipping());
    }

    public function test_total_includes_subtotal_plus_shipping()
    {
        Product::factory()->create(['price' => 1]);

        session()->forget(CartService::SESSION_KEY);
        $this->cart->add(1, 'A', 100);
        // subtotal 100 → frete 20 (entre 0 e 52)
        $this->assertEquals(115.00, $this->cart->total());
    }
}
