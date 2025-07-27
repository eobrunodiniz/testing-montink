<?php

namespace App\Http\Controllers;

use App\Services\CartService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class CartController extends Controller
{
    public function __construct(private CartService $cart) {}
    /**
     * Exibe o conteúdo do carrinho de compras.
     *
     * @return View
     * @author Bruno Diniz <https://github.com/eobrunodiniz>
     */
    public function index(): View
    {
        $items    = $this->cart->all();
        $subtotal = $this->cart->subtotal();
        $shipping = $this->cart->shipping();
        $total    = $subtotal + $shipping;

        return view('cart.index', compact('items', 'subtotal', 'shipping', 'total'));
    }

    /**
     * Adiciona um item ao carrinho de compras.
     *
     * @param  Request $request
     * @return RedirectResponse
     * @author Bruno Diniz <https://github.com/eobrunodiniz>
     */
    public function add(Request $request): RedirectResponse
    {
        $this->cart->add(
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
     * @param  Request $request
     * @return RedirectResponse
     * @author Bruno Diniz <https://github.com/eobrunodiniz>
     */
    public function update(Request $request): RedirectResponse
    {
        $this->cart->update(
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
     * @param  Request $request
     * @return RedirectResponse
     * @author Bruno Diniz <https://github.com/eobrunodiniz>
     */
    public function remove(Request $request): RedirectResponse
    {
        $this->cart->remove(
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
     * @return RedirectResponse
     * @author Bruno Diniz <https://github.com/eobrunodiniz>
     */
    public function checkout(): RedirectResponse
    {
        return redirect()->route('cart.checkout');
    }
}
