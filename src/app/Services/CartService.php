<?php

namespace App\Services;

use App\Models\Product;

/**
 * Manipula as operações do carrinho de compras em sessão.
 *
 * @author Bruno Diniz <https://github.com/eobrunodiniz>
 */
class CartService
{
    const SESSION_KEY = 'cart';

    /**
     * Recupera todos os itens do carrinho atual.
     *
     * @return array
     */
    public function all(): array
    {
        return session(self::SESSION_KEY, []);
    }

    /**
     * Adiciona um item ao carrinho.
     *
     * @param int    $productId ID do produto
     * @param string $variation Variação escolhida
     * @param int    $qty       Quantidade
     */
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

    /**
     * Remove um item do carrinho.
     *
     * @param int    $productId
     * @param string $variation
     */
    public function remove(int $productId, string $variation): void
    {
        $cart = $this->all();
        unset($cart[$productId . ':' . $variation]);
        session([self::SESSION_KEY => $cart]);
    }

    /**
     * Atualiza a quantidade de um item do carrinho.
     *
     * @param int    $productId
     * @param string $variation
     * @param int    $qty
     */
    public function update(int $productId, string $variation, int $qty): void
    {
        $cart = $this->all();
        $key  = $productId . ':' . $variation;
        if (isset($cart[$key])) {
            $cart[$key]['qty'] = $qty;
            session([self::SESSION_KEY => $cart]);
        }
    }

    /**
     * Calcula o subtotal de todos os itens.
     */
    public function subtotal(): float
    {
        return array_reduce($this->all(), fn($sum, $item) => $sum + $item['price'] * $item['qty'], 0.0);
    }

    /**
     * Calcula o valor do frete conforme as regras de negócio.
     */
    public function shipping(): float
    {
        $sub = $this->subtotal();
        if ($sub >= 52 && $sub <= 166.59) return 15.00;
        if ($sub > 200)                  return 0.00;
        return 20.00;
    }

    /**
     * Retorna o total do pedido (subtotal + frete).
     */
    public function total(): float
    {
        return $this->subtotal() + $this->shipping();
    }
}
