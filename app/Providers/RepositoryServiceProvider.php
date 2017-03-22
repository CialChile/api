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
        $this->app->bind(\App\Etrack\Repositories\Auth\RoleRepository::class, \App\Etrack\Repositories\Auth\RoleRepositoryEloquent::class);
        $this->app->bind(\App\Etrack\Repositories\Company\CompanyRepository::class, \App\Etrack\Repositories\Company\CompanyRepositoryEloquent::class);
        $this->app->bind(\App\Etrack\Repositories\Modules\ModuleRepository::class, \App\Etrack\Repositories\Modules\ModuleRepositoryEloquent::class);
        $this->app->bind(\App\Etrack\Repositories\Modules\AbilityRepository::class, \App\Etrack\Repositories\Modules\AbilityRepositoryEloquent::class);
        $this->app->bind(\App\Etrack\Repositories\Company\CompanyFieldsRepository::class, \App\Etrack\Repositories\Company\CompanyFieldsRepositoryEloquent::class);
        $this->app->bind(\App\Etrack\Repositories\Worker\WorkerRepository::class, \App\Etrack\Repositories\Worker\WorkerRepositoryEloquent::class);
        $this->app->bind(\App\Etrack\Repositories\Assets\AssetRepository::class, \App\Etrack\Repositories\Assets\AssetRepositoryEloquent::class);
        $this->app->bind(\App\Etrack\Repositories\Assets\BrandRepository::class, \App\Etrack\Repositories\Assets\BrandRepositoryEloquent::class);
        $this->app->bind(\App\Etrack\Repositories\Assets\BrandModelRepository::class, \App\Etrack\Repositories\Assets\BrandModelRepositoryEloquent::class);
        $this->app->bind(\App\Etrack\Repositories\Assets\WorkplaceRepository::class, \App\Etrack\Repositories\Assets\WorkplaceRepositoryEloquent::class);
        $this->app->bind(\App\Etrack\Repositories\StatusRepository::class, \App\Etrack\Repositories\StatusRepositoryEloquent::class);
        $this->app->bind(\App\Etrack\Repositories\Assets\CategoryRepository::class, \App\Etrack\Repositories\Assets\CategoryRepositoryEloquent::class);
        $this->app->bind(\App\Etrack\Repositories\Assets\SubcategoryRepository::class, \App\Etrack\Repositories\Assets\SubcategoryRepositoryEloquent::class);
        //:end-bindings:
    }
}
