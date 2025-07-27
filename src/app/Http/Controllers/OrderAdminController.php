<?php

namespace App\Http\Controllers;

use App\Repositories\IOrderRepository;
use App\Services\OrderService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class OrderAdminController extends Controller
{
    /**
     * Injeta as dependências dos serviços de pedidos e repositório de pedidos.
     *
     * @param  OrderService  $orders  Serviço de pedidos.
     * @param  IOrderRepository  $repo  Repositório de pedidos.
     *
     * @author Bruno Diniz <https://github.com/eobrunodiniz>
     */
    public function __construct(
        private OrderService $orders,
        private IOrderRepository $repo
    ) {}

    /**
     * Exibe a lista de todos os pedidos.
     *
     * @author Bruno Diniz <https://github.com/eobrunodiniz>
     */
    public function index(): View
    {
        $list = $this->repo->all();

        return view('orders.index', ['orders' => $list]);
    }

    /**
     * Atualiza o status de um pedido.
     *
     * @param  Request  $req  Requisição HTTP contendo o novo status.
     * @param  int  $id  ID do pedido.
     *
     * @author Bruno Diniz <https://github.com/eobrunodiniz>
     */
    public function updateStatus(Request $req, int $id): RedirectResponse
    {
        $req->validate(['status' => 'required|in:pending,cancelled,processing,completed']);
        $this->orders->updateStatus($id, $req->input('status'));

        return back()->with('success', 'Status atualizado.');
    }

    /**
     * Remove um pedido do sistema.
     *
     * @param  int  $id  ID do pedido.
     *
     * @author Bruno Diniz <https://github.com/eobrunodiniz>
     */
    public function destroy(int $id): RedirectResponse
    {
        $this->orders->delete($id);

        return back()->with('success', 'Pedido removido.');
    }
}
