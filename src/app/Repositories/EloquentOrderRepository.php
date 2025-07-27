<?php

namespace App\Repositories;

use App\Models\Order;
use Illuminate\Database\Eloquent\Collection;

class EloquentOrderRepository implements IOrderRepository
{
    public function create(array $data): Order
    {
        return Order::create($data);
    }

    public function find(int $id): ?Order
    {
        return Order::find($id);
    }

    public function updateStatus(int $id, string $status): Order
    {
        $order = $this->find($id);
        $order->status = $status;
        $order->save();
        return $order;
    }

    public function delete(int $id): void
    {
        Order::destroy($id);
    }

    public function all(): Collection
    {
        return Order::with('coupon')->orderBy('id', 'desc')->get();
    }
}
