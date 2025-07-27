<?php

namespace App\Repositories;

use App\Models\Order;
use Illuminate\Database\Eloquent\Collection;

/**
 * Interface de repositório de pedidos.
 *
 * @author Bruno Diniz <https://github.com/eobrunodiniz>
 */
interface IOrderRepository
{
    /** @return Order */
    public function create(array $data): Order;

    /**
     * @param int $id
     * @return Order|null
     */
    public function find(int $id): ?Order;

    /**
     * Atualiza o status do pedido.
     */
    public function updateStatus(int $id, string $status): Order;

    /**
     * @param int $id
     */
    public function delete(int $id): void;

    /** @return Collection */
    public function all(): Collection;
}
