<?php

namespace App\Http\Controllers;

use App\Http\Requests\CheckoutRequest;
use App\Mail\OrderPlaced;
use App\Models\Order;
use App\Services\CartService;
use App\Services\OrderService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Mail;
use Illuminate\View\View;

class CheckoutController extends Controller
{
    /**
     * Injeta as dependências dos serviços de pedido e carrinho.
     *
     * @param  OrderService  $orders  Serviço de pedidos.
     * @param  CartService  $cart  Serviço de carrinho de compras.
     *
     * @author Bruno Diniz <https://github.com/eobrunodiniz>
     */
    public function __construct(
        protected OrderService $orders,
        protected CartService $cart
    ) {}

    /**
     * Exibe a página de checkout com os dados do carrinho.
     *
     * @author Bruno Diniz <https://github.com/eobrunodiniz>
     */
    public function index(): View
    {
        $items = $this->cart->all();
        $subtotal = $this->cart->subtotal();
        $shipping = $this->cart->shipping();
        $total = $this->cart->total();

        return view('checkout.index', compact('items', 'subtotal', 'shipping', 'total'));
    }

    /**
     * Processa o pedido, envia e-mail de confirmação, limpa o carrinho e redireciona para a tela de agradecimento.
     *
     * @param  CheckoutRequest  $request  Dados validados do checkout.
     *
     * @author Bruno Diniz <https://github.com/eobrunodiniz>
     */
    public function store(CheckoutRequest $request): RedirectResponse
    {
        $data = $request->validated();

        $order = $this->orders->placeOrder(
            $data,
            $data['coupon_code'] ?? null,
            $data['email']
        );

        Mail::to($data['email'])->send(new OrderPlaced($order));

        session()->forget(CartService::SESSION_KEY);

        return redirect()
            ->route('checkout.thanks', $order->id);
    }

    /**
     * Exibe a página de agradecimento após a finalização do pedido.
     *
     * @param  int  $id  ID do pedido.
     *
     * @author Bruno Diniz <https://github.com/eobrunodiniz>
     */
    public function thanks(int $id): View
    {
        $order = Order::findOrFail($id);

        return view('checkout.thanks', compact('order'));
    }
}
