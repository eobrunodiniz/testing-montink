<?php

namespace App\Services;

use App\Models\Product as ProductModel;
use App\Repositories\IProductRepository;
use App\Models\Stock;
use Illuminate\Support\Facades\DB;

class ProductService
{
    public function __construct(private IProductRepository $repo) {}

    public function list()
    {
        return $this->repo->all();
    }

    public function store(array $data, array $variations, array $quantities)
    {
        return DB::transaction(function () use ($data, $variations, $quantities) {
            $data['variations'] = $variations;
            $product = $this->repo->create($data);

            foreach ($variations as $i => $var) {
                Stock::create([
                    'product_id' => $product->id,
                    'variation'  => $var,
                    'quantity'   => $quantities[$i] ?? 0,
                ]);
            }

            return $product;
        });
    }

    public function update(int $id, array $data, array $variations, array $quantities)
    {
        return DB::transaction(function () use ($id, $data, $variations, $quantities) {
            $data['variations'] = $variations;
            $product = $this->repo->update($id, $data);

            // sincroniza stocks
            $product->stocks()->delete();
            foreach ($variations as $i => $var) {
                Stock::create([
                    'product_id' => $product->id,
                    'variation'  => $var,
                    'quantity'   => $quantities[$i] ?? 0,
                ]);
            }

            return $product;
        });
    }

    public function destroy(int $id): void
    {
        $this->repo->delete($id);
    }

    /**
     * Retorna um produto pelo ID.
     */
    public function find(int $id): ?ProductModel
    {
        return $this->repo->find($id);
    }
}
