<?php

namespace App\Services;

use App\Models\Coupon;
use App\Repositories\ICouponRepository;

/**
 * Serviço de gerenciamento de cupons de desconto.
 *
 * @author Bruno Diniz <https://github.com/eobrunodiniz>
 */
class CouponService
{
    /**
     * Construtor.
     */
    public function __construct(private ICouponRepository $repo) {}

    /**
     * Lista todos os cupons cadastrados.
     */
    public function list()
    {
        return $this->repo->all();
    }

    /**
     * Cria um novo cupom.
     */
    public function store(array $data): Coupon
    {
        return $this->repo->create($data);
    }

    /**
     * Busca um cupom pelo ID.
     */
    public function find(int $id): ?Coupon
    {
        return $this->repo->find($id);
    }

    /**
     * Atualiza um cupom.
     */
    public function update(int $id, array $data): Coupon
    {
        return $this->repo->update($id, $data);
    }

    /**
     * Remove um cupom.
     */
    public function destroy(int $id): void
    {
        $this->repo->delete($id);
    }
}
