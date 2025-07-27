<?php

namespace App\Repositories;

use App\Models\Product;

/**
 * Interface de repositório para produtos.
 *
 * @author Bruno Diniz <https://github.com/eobrunodiniz>
 */
interface IProductRepository
{
    /** @return mixed */
    public function all();

    /**
     * @param int $id
     * @return Product|null
     */
    public function find(int $id): ?Product;

    /**
     * @param array $data
     * @return Product
     */
    public function create(array $data): Product;

    /**
     * @param int   $id
     * @param array $data
     * @return Product
     */
    public function update(int $id, array $data): Product;

    /**
     * @param int $id
     */
    public function delete(int $id): void;
}
