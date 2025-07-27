<?php

namespace App\Services;

use App\Models\Order;
use App\Models\Stock;
use App\Repositories\ICouponRepository;
use App\Services\CartService;

class OrderService
{
    public function __construct(
        private CartService $cartService,
        private ICouponRepository $coupons,
    ) {}

    /**
     * Coloca o pedido, persiste no banco, decrementa estoque e retorna o modelo Order.
     */
    public function placeOrder(array $addressData, ?string $couponCode, string $email): Order
    {
        // Itens do carrinho em sessão
        $items = session()->get(CartService::SESSION_KEY, []);

        // Calcula subtotal
        $subtotal = array_sum(array_map(
            fn($item) => $item['price'] * $item['qty'],
            $items
        ));

        // Calcula frete
        $shipping = $this->cartService->shipping();

        // Aplica cupom se fornecido e válido
        $discount = 0;
        $coupon_id = null;
        if ($couponCode) {
            $coupon = $this->coupons->findByCode($couponCode);
            if ($coupon && $subtotal >= $coupon->min_subtotal) {
                $discount = $coupon->discount_type === 'percent'
                    ? ($subtotal * $coupon->discount_value / 100)
                    : $coupon->discount_value;
                $coupon_id = $coupon->id;
            }
        }

        // Total final = subtotal + frete - desconto
        $total = $subtotal + $shipping - $discount;

        // Persiste o pedido
        $order = Order::create([
            'items'       => $items,
            'subtotal'    => $subtotal,
            'shipping'    => $shipping,
            'discount'    => $discount,
            'total'       => $total,
            'coupon_id'   => $coupon_id,
            'email'       => $email,
            'cep'         => $addressData['cep'],
            'street'      => $addressData['street'] ?? '',
            'number'      => $addressData['number'],
            'complement'  => $addressData['complement'] ?? null,
            'district'    => $addressData['district'],
            'city'        => $addressData['city'],
            'state'       => $addressData['state'],
            'status'      => 'completed',
        ]);

        // Decrementa o estoque de cada item
        foreach ($items as $item) {
            Stock::where('product_id', $item['product_id'])
                ->where('variation',  $item['variation'])
                ->decrement('quantity', $item['qty']);
        }

        // Limpa o carrinho da sessão
        session()->forget(CartService::SESSION_KEY);

        return $order;
    }
}
