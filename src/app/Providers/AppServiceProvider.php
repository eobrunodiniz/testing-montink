<?php

namespace App\Providers;

use App\Repositories\EloquentCouponRepository;
use App\Repositories\EloquentOrderRepository;
use App\Repositories\EloquentProductRepository;
use App\Repositories\ICouponRepository;
use App\Repositories\IOrderRepository;
use App\Repositories\IProductRepository;
use App\Services\CouponService;
use App\Services\OrderService;
use App\Services\ProductService;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @author Bruno Diniz <https://github.com/eobrunodiniz>
     */
    public function register(): void
    {
        $this->app->bind(IProductRepository::class, EloquentProductRepository::class);
        $this->app->bind(ProductService::class, ProductService::class);

        $this->app->bind(ICouponRepository::class, EloquentCouponRepository::class);
        $this->app->bind(CouponService::class, CouponService::class);

        $this->app->bind(IOrderRepository::class, EloquentOrderRepository::class);
        $this->app->bind(OrderService::class, OrderService::class);
    }

    /**
     * Bootstrap any application services.
     *
     * @author Bruno Diniz <https://github.com/eobrunodiniz>
     */
    public function boot(): void
    {
        
    }
}
