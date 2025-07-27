<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Http;
use App\Models\Product;
use App\Models\Stock;
use App\Models\Coupon;
use App\Mail\OrderPlaced;
use App\Services\OrderService;

class CheckoutFlowTest extends TestCase
{
    use RefreshDatabase;
    private OrderService $service;

    protected function setUp(): void
    {
        parent::setUp();
        $this->service = $this->app->make(OrderService::class);
    }

    public function test_full_checkout_flow_with_coupon_and_stock_decrement()
    {
        // 1) Preparar produto, estoque e cupom
        $product = Product::factory()->create(['price' => 50.00]);
        Stock::factory()->create([
            'product_id' => $product->id,
            'variation' => 'M',
            'quantity'  => 10,
        ]);

        $coupon = Coupon::factory()->create([
            'discount_type'  => 'percent',
            'discount_value' => 20,
            'min_subtotal'   => 10,
            'valid_from'     => now()->subDay(),
            'valid_to'       => now()->addDay(),
        ]);

        // 2) Simular lookup de CEP no viacep
        Http::fake([
            'viacep.com.br/*' => Http::response([
                'cep'         => '01001-000',
                'logradouro'  => 'Praça da Sé',
                'bairro'      => 'Sé',
                'localidade'  => 'São Paulo',
                'uf'          => 'SP',
            ], 200)
        ]);

        // 3) Adicionar item no carrinho (qty=3 → subtotal=150 → frete=15)
        session(['cart' => [
            "{$product->id}:M" => [
                'product_id' => $product->id,
                'name' => $product->name,
                'variation' => 'M',
                'price' => 50.00,
                'qty' => 3,
            ]
        ]]);

        // 4) Fake de e-mail
        Mail::fake();

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
        $addressData = array_combine($address, array_fill(0, count($address), 'X'));

        // 5) Enviar checkout
        $payload = [
            'email'       => 'bruno.diniz@montink.com.br',
            'cep'         => $addressData['cep'],
            'number'      => $addressData['number'],
            'complement'  => $addressData['complement'],
            'district'    => $addressData['district'],
            'city'        => $addressData['city'],
            'state'       => $addressData['state'],
            'coupon_code' => $coupon->code,
        ];

        $response = $this->post(route('checkout.store'), $payload);

        // 6) Assert de redirecionamento e sessão limpa
        $order = $this->service->placeOrder($addressData, $coupon->code, 'bruno.diniz@montink.com.br');
        $order = \App\Models\Order::first();
        $response->assertRedirect(route('checkout.thanks', $order->id));
        $this->assertEmpty(session('cart'));

        // 7) Pedido no banco: subtotal 150, frete 15, desconto 20, total 145
        $this->assertDatabaseHas('orders', [
            'id'        => $order->id,
            'subtotal'  => 150.00,
            'shipping'  => 15.00,
            'discount'  => 30.00,
            'total'     => 135.00,
            'coupon_id' => $coupon->id,
            'email'     => 'bruno.diniz@montink.com.br',
            'status'    => 'completed',
        ]);

        // 8) Estoque decrementado (antes 10, depois 7)
        $this->assertDatabaseHas('stocks', [
            'product_id' => $product->id,
            'variation' => 'M',
            'quantity'  => 7,
        ]);

        // 9) E-mail enviado
        Mail::assertSent(OrderPlaced::class, function ($mail) use ($order) {
            return $mail->hasTo('bruno.diniz@montink.com.br')
                && $mail->order->id === $order->id;
        });
    }
}
