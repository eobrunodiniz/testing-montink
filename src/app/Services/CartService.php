<?php

namespace App\Services;

use App\Models\Product;

class CartService
{
    const SESSION_KEY = 'cart';

    public function all(): array
    {
        return session(self::SESSION_KEY, []);
    }

    public function add(int $productId, string $variation, int $qty): void
    {
        $cart = $this->all();
        $key  = $productId . ':' . $variation;

        $product = Product::findOrFail($productId);
        $price   = $product->price;

        if (isset($cart[$key])) {
            $cart[$key]['qty'] += $qty;
        } else {
            $cart[$key] = [
                'product_id' => $productId,
                'name'       => $product->name,
                'variation'  => $variation,
                'price'      => $price,
                'qty'        => $qty,
            ];
        }

        session([self::SESSION_KEY => $cart]);
    }

    public function remove(int $productId, string $variation): void
    {
        $cart = $this->all();
        unset($cart[$productId . ':' . $variation]);
        session([self::SESSION_KEY => $cart]);
    }

    public function update(int $productId, string $variation, int $qty): void
    {
        $cart = $this->all();
        $key  = $productId . ':' . $variation;
        if (isset($cart[$key])) {
            $cart[$key]['qty'] = $qty;
            session([self::SESSION_KEY => $cart]);
        }
    }

    public function subtotal(): float
    {
        return array_reduce($this->all(), fn($sum, $item) => $sum + $item['price'] * $item['qty'], 0.0);
    }

    public function shipping(): float
    {
        $sub = $this->subtotal();
        if ($sub >= 52 && $sub <= 166.59) return 15.00;
        if ($sub > 200)                  return 0.00;
        return 20.00;
    }

    public function total(): float
    {
        return $this->subtotal() + $this->shipping();
    }
}
