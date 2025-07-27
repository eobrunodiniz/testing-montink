<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\OrderService;

class WebhookController extends Controller
{
    /**
     * Injeta o serviço de pedidos.
     *
     * @param OrderService $orders Serviço responsável pela lógica de pedidos.
     * @author Bruno Diniz <https://github.com/eobrunodiniz>
     */
    public function __construct(private OrderService $orders) {}

    /**
     * Manipula requisições de webhook para atualização ou cancelamento de pedidos.
     *
     * @param Request $req Requisição HTTP contendo os dados do pedido e status.
     * @return \Illuminate\Http\JsonResponse
     * @author Bruno Diniz <https://github.com/eobrunodiniz>
     */
    public function handle(Request $req)
    {
        $data = $req->validate([
            'id'     => 'required|integer|exists:orders,id',
            'status' => 'required|string',
        ]);

        if ($data['status'] === 'cancelled') {
            $this->orders->delete($data['id']);
        } else {
            $this->orders->updateStatus($data['id'], $data['status']);
        }

        return response()->json(['success' => true]);
    }
}
