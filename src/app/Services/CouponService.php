<?php

namespace App\Services;

use App\Repositories\ICouponRepository;
use App\Models\Coupon;

class CouponService
{
    public function __construct(private ICouponRepository $repo) {}

    public function list()
    {
        return $this->repo->all();
    }

    public function store(array $data): Coupon
    {
        return $this->repo->create($data);
    }

    public function find(int $id): ?Coupon
    {
        return $this->repo->find($id);
    }

    public function update(int $id, array $data): Coupon
    {
        return $this->repo->update($id, $data);
    }

    public function destroy(int $id): void
    {
        $this->repo->delete($id);
    }
}
