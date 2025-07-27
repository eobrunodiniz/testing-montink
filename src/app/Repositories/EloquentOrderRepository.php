<?php

namespace App\Repositories;

use App\Models\Order;
use Illuminate\Database\Eloquent\Collection;

/**
 * Implementação Eloquent do repositório de pedidos.
 *
 * @author Bruno Diniz <https://github.com/eobrunodiniz>
 */
class EloquentOrderRepository implements IOrderRepository
{
    /** {@inheritDoc} */
    public function create(array $data): Order
    {
        return Order::create($data);
    }

    /** {@inheritDoc} */
    public function find(int $id): ?Order
    {
        return Order::find($id);
    }

    /** {@inheritDoc} */
    public function updateStatus(int $id, string $status): Order
    {
        $order = $this->find($id);
        $order->status = $status;
        $order->save();

        return $order;
    }

    /** {@inheritDoc} */
    public function delete(int $id): void
    {
        Order::destroy($id);
    }

    /** {@inheritDoc} */
    public function all(): Collection
    {
        return Order::with('coupon')->orderBy('id', 'desc')->get();
    }
}
