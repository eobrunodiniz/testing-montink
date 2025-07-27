<?php

namespace App\Repositories;

use App\Models\Product;

interface IProductRepository
{
    public function all();
    public function find(int $id): ?Product;
    public function create(array $data): Product;
    public function update(int $id, array $data): Product;
    public function delete(int $id): void;
}
