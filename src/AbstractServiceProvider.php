<?php

namespace gitkv\Uniteller;


//use gitkv\Uniteller\Facade\Uniteller;
use Illuminate\Support\ServiceProvider;

abstract class AbstractServiceProvider extends ServiceProvider {

    public function boot() {
        $this->loadViewsFrom(__DIR__ . '/Views', 'uniteller');
    }

    public function register() {

        /*if (!class_exists(Uniteller::class)) {
            class_alias(UnitellerBase::class, Uniteller::class);
        }*/

        $this->mergeConfigFrom(
            __DIR__ . '/../config/uniteller.php',
            'uniteller'
        );

        if (config('uniteller.useRoutes')) {
            $this->app->router->group([
                'namespace' => 'gitkv\Uniteller\Controllers',
            ], function ($router) {
                require __DIR__ . '/routes.php';
            });
        }

        $this->app->singleton(UnitellerBase::class, function () {
            return new UnitellerBase(
                config('uniteller.shopId'),
                config('uniteller.login'),
                config('uniteller.password'),
                config('uniteller.baseUrl'),
                config('uniteller.successUrl'),
                config('uniteller.failureUrl')
            );
        });
    }
}
