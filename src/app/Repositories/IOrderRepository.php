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
    public function create(array $data): Order;

    public function find(int $id): ?Order;

    /**
     * Atualiza o status do pedido.
     */
    public function updateStatus(int $id, string $status): Order;

    public function delete(int $id): void;

    public function all(): Collection;
}
