<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CartController extends Controller
{
    /**
     * Exibe o conteúdo do carrinho de compras.
     *
     * @return \Illuminate\View\View
     * @author Bruno Diniz <https://github.com/eobrunodiniz>
     */
    public function index()
    {
        $items    = session()->get(\App\Services\CartService::SESSION_KEY, []);
        $subtotal = app(\App\Services\CartService::class)->subtotal();
        $shipping = app(\App\Services\CartService::class)->shipping();
        $total    = $subtotal + $shipping;

        return view('cart.index', compact('items', 'subtotal', 'shipping', 'total'));
    }

    /**
     * Adiciona um item ao carrinho de compras.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     * @author Bruno Diniz <https://github.com/eobrunodiniz>
     */
    public function add(Request $request)
    {
        app(\App\Services\CartService::class)->add(
            $request->input('product_id'),
            $request->input('variation'),
            $request->input('qty'),
        );

        return redirect()
            ->route('cart.index')
            ->with('success', 'Item adicionado ao carrinho.');
    }

    /**
     * Atualiza a quantidade ou variação de um item no carrinho.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     * @author Bruno Diniz <https://github.com/eobrunodiniz>
     */
    public function update(Request $request)
    {
        app(\App\Services\CartService::class)->update(
            $request->input('product_id'),
            $request->input('variation'),
            $request->input('qty'),
        );

        return redirect()
            ->route('cart.index')
            ->with('success', 'Item atualizado no carrinho.');
    }

    /**
     * Remove um item do carrinho de compras.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     * @author Bruno Diniz <https://github.com/eobrunodiniz>
     */
    public function remove(Request $request)
    {
        app(\App\Services\CartService::class)->remove(
            $request->input('product_id'),
            $request->input('variation'),
        );

        return redirect()
            ->route('cart.index')
            ->with('success', 'Item removido do carrinho.');
    }

    /**
     * Redireciona para a rota de checkout do carrinho.
     *
     * @return \Illuminate\Http\RedirectResponse
     * @author Bruno Diniz <https://github.com/eobrunodiniz>
     */
    public function checkout()
    {
        return redirect()->route('cart.checkout');
    }
}
