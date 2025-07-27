<?php

namespace App\Repositories;

use App\Models\Coupon;
use Illuminate\Database\Eloquent\Collection;

class EloquentCouponRepository implements ICouponRepository
{
    public function all(): Collection
    {
        return Coupon::orderBy('code')->get();
    }

    public function find(int $id): ?Coupon
    {
        return Coupon::find($id);
    }

    public function create(array $data): Coupon
    {
        return Coupon::create($data);
    }

    public function update(int $id, array $data): Coupon
    {
        $coupon = $this->find($id);
        $coupon->update($data);
        return $coupon;
    }

    public function delete(int $id): void
    {
        Coupon::destroy($id);
    }

    // ↓ Implementação do novo método
    public function findByCode(string $code): ?Coupon
    {
        return Coupon::where('code', $code)->first();
    }
}
