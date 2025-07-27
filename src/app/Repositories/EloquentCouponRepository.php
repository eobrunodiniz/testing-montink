<?php

namespace App\Repositories;

use App\Models\Coupon;
use Illuminate\Database\Eloquent\Collection;

/**
 * Implementação Eloquent do repositório de cupons.
 *
 * @author Bruno Diniz <https://github.com/eobrunodiniz>
 */
class EloquentCouponRepository implements ICouponRepository
{
    /** {@inheritDoc} */
    public function all(): Collection
    {
        return Coupon::orderBy('code')->get();
    }

    /** {@inheritDoc} */
    public function find(int $id): ?Coupon
    {
        return Coupon::find($id);
    }

    /** {@inheritDoc} */
    public function create(array $data): Coupon
    {
        return Coupon::create($data);
    }

    /** {@inheritDoc} */
    public function update(int $id, array $data): Coupon
    {
        $coupon = $this->find($id);
        $coupon->update($data);

        return $coupon;
    }

    /** {@inheritDoc} */
    public function delete(int $id): void
    {
        Coupon::destroy($id);
    }

    /** {@inheritDoc} */
    public function findByCode(string $code): ?Coupon
    {
        return Coupon::where('code', $code)->first();
    }
}
