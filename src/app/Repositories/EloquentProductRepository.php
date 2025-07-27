<?php

namespace App\Repositories;

use App\Models\Product;
use Illuminate\Database\Eloquent\Collection;

class EloquentProductRepository implements IProductRepository
{
    public function all(): Collection
    {
        return Product::with('stocks')->get();
    }

    public function find(int $id): ?Product
    {
        return Product::with('stocks')->find($id);
    }

    public function create(array $data): Product
    {
        return Product::create($data);
    }

    public function update(int $id, array $data): Product
    {
        $product = $this->find($id);
        $product->update($data);
        return $product;
    }

    public function delete(int $id): void
    {
        Product::destroy($id);
    }
}
