<?php

namespace App\Http;

use Illuminate\Foundation\Http\Kernel as HttpKernel;

class Kernel extends HttpKernel
{
    /**
     * Bootstrap any application services.
     */
    protected function bootstrappers()
    {
        return array_merge(parent::bootstrappers(), [
            //
        ]);
    }

    /**
     * The application's route middleware.
     *
     * Register your custom route middlewares here.
     */
    protected $routeMiddleware = [
        'role' => \App\Http\Middleware\CheckRole::class,
    ];
}
