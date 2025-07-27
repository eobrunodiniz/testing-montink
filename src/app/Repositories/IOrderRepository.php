<?php

namespace App\Repositories;

use App\Models\Order;
use Illuminate\Database\Eloquent\Collection;

interface IOrderRepository
{
    public function create(array $data): Order;
    public function find(int $id): ?Order;
    public function updateStatus(int $id, string $status): Order;
    public function delete(int $id): void;
    public function all(): Collection;
}
