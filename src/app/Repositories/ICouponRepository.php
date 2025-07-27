<?php

namespace App\Repositories;

use App\Models\Coupon;
use Illuminate\Database\Eloquent\Collection;

interface ICouponRepository
{
    public function all(): Collection;
    public function find(int $id): ?Coupon;
    public function create(array $data): Coupon;
    public function update(int $id, array $data): Coupon;
    public function delete(int $id): void;
    public function findByCode(string $code): ?Coupon;
}
