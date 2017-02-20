<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(\App\Etrack\Repositories\Auth\UserRepository::class, \App\Etrack\Repositories\Auth\UserRepositoryEloquent::class);
        //:end-bindings:
    }
}
