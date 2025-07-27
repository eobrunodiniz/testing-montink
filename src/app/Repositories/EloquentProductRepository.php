<?php

namespace App\Repositories;

use App\Models\Product;
use Illuminate\Database\Eloquent\Collection;

/**
 * Implementação Eloquent do repositório de produtos.
 *
 * @author Bruno Diniz <https://github.com/eobrunodiniz>
 */
class EloquentProductRepository implements IProductRepository
{
    /** @inheritDoc */
    public function all(): Collection
    {
        return Product::with('stocks')->get();
    }

    /** @inheritDoc */
    public function find(int $id): ?Product
    {
        return Product::with('stocks')->find($id);
    }

    /** @inheritDoc */
    public function create(array $data): Product
    {
        return Product::create($data);
    }

    /** @inheritDoc */
    public function update(int $id, array $data): Product
    {
        $product = $this->find($id);
        $product->update($data);
        return $product;
    }

    /** @inheritDoc */
    public function delete(int $id): void
    {
        Product::destroy($id);
    }
}
