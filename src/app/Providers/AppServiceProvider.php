<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        // Repository
        $this->app->bind(
            \App\Repositories\IProductRepository::class,
            \App\Repositories\EloquentProductRepository::class
        );

        // Service
        $this->app->bind(
            \App\Services\ProductService::class,
            \App\Services\ProductService::class
        );

        // Repository
        $this->app->bind(
            \App\Repositories\ICouponRepository::class,
            \App\Repositories\EloquentCouponRepository::class
        );

        // Service
        $this->app->bind(
            \App\Services\CouponService::class,
            \App\Services\CouponService::class
        );

        // Repository
        $this->app->bind(
            \App\Repositories\IOrderRepository::class,
            \App\Repositories\EloquentOrderRepository::class
        );

        // Service
        $this->app->bind(
            \App\Services\OrderService::class,
            \App\Services\OrderService::class
        );
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
