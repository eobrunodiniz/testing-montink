<?php

namespace App\Services;

use App\Models\Order;
use App\Models\Stock;
use App\Repositories\ICouponRepository;
use App\Services\CartService;

/**
 * Serviço responsável pelo processamento dos pedidos.
 *
 * @author Bruno Diniz <https://github.com/eobrunodiniz>
 */
class OrderService
{
    public function __construct(
        private CartService $cartService,
        private ICouponRepository $coupons,
    ) {}

    /**
     * Registra um novo pedido e atualiza o estoque.
     *
     * @param array       $addressData Dados de endereço
     * @param string|null $couponCode  Código do cupom de desconto
     * @param string      $email       E-mail do comprador
     * @return Order
     */
    public function placeOrder(array $addressData, ?string $couponCode, string $email): Order
    {
        $items = session()->get(CartService::SESSION_KEY, []);
        $subtotal = array_sum(array_map(
            fn($item) => $item['price'] * $item['qty'],
            $items
        ));
        $shipping = $this->cartService->shipping();

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
        $total = $subtotal + $shipping - $discount;
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

        foreach ($items as $item) {
            Stock::where('product_id', $item['product_id'])
                ->where('variation',  $item['variation'])
                ->decrement('quantity', $item['qty']);
        }
        session()->forget(CartService::SESSION_KEY);

        return $order;
    }
}
