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

    public function find(int $id): ?Product;

    public function create(array $data): Product;

    public function update(int $id, array $data): Product;

    public function delete(int $id): void;
}
