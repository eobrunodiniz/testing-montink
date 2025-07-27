<?php

namespace App\Services;

use App\Models\Product as ProductModel;
use App\Models\Stock;
use App\Repositories\IProductRepository;
use Illuminate\Support\Facades\DB;

/**
 * Serviço responsável pelo gerenciamento de produtos.
 *
 * @author Bruno Diniz <https://github.com/eobrunodiniz>
 */
class ProductService
{
    /**
     * Construtor do serviço.
     */
    public function __construct(private IProductRepository $repo) {}

    /**
     * Retorna todos os produtos cadastrados.
     */
    public function list()
    {
        return $this->repo->all();
    }

    /**
     * Cadastra um novo produto com suas variações e estoque.
     *
     * @return ProductModel
     */
    public function store(array $data, array $variations, array $quantities)
    {
        return DB::transaction(function () use ($data, $variations, $quantities) {
            $data['variations'] = $variations;
            $product = $this->repo->create($data);

            foreach ($variations as $i => $var) {
                Stock::create([
                    'product_id' => $product->id,
                    'variation' => $var,
                    'quantity' => $quantities[$i] ?? 0,
                ]);
            }

            return $product;
        });
    }

    /**
     * Atualiza um produto existente e recria seu estoque.
     */
    public function update(int $id, array $data, array $variations, array $quantities)
    {
        return DB::transaction(function () use ($id, $data, $variations, $quantities) {
            $data['variations'] = $variations;
            $product = $this->repo->update($id, $data);

            $product->stocks()->delete();
            foreach ($variations as $i => $var) {
                Stock::create([
                    'product_id' => $product->id,
                    'variation' => $var,
                    'quantity' => $quantities[$i] ?? 0,
                ]);
            }

            return $product;
        });
    }

    /**
     * Exclui um produto do repositório.
     */
    public function destroy(int $id): void
    {
        $this->repo->delete($id);
    }

    /**
     * Busca um produto pelo ID.
     */
    public function find(int $id): ?ProductModel
    {
        return $this->repo->find($id);
    }
}
