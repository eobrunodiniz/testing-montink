<?php

namespace App\Repositories;

use App\Models\Coupon;
use Illuminate\Database\Eloquent\Collection;

/**
 * Interface de repositório de cupons.
 *
 * @author Bruno Diniz <https://github.com/eobrunodiniz>
 */
interface ICouponRepository
{
    /** @return Collection */
    public function all(): Collection;

    /**
     * @param int $id
     * @return Coupon|null
     */
    public function find(int $id): ?Coupon;

    /**
     * @param array $data
     * @return Coupon
     */
    public function create(array $data): Coupon;

    /**
     * @param int   $id
     * @param array $data
     * @return Coupon
     */
    public function update(int $id, array $data): Coupon;

    /**
     * @param int $id
     */
    public function delete(int $id): void;

    /**
     * @param string $code
     * @return Coupon|null
     */
    public function findByCode(string $code): ?Coupon;
}
