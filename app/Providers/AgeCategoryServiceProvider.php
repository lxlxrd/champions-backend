<?php

namespace App\Providers;

use App\Services\AgeCategoryService;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\Support\DeferrableProvider;
use Illuminate\Support\ServiceProvider;

class AgeCategoryServiceProvider extends ServiceProvider implements DeferrableProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
        $this->app->singleton(AgeCategoryService::class,  function(Application $app){
            return new AgeCategoryService(); 
        }); 
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }


    public function  provides(): array
    {
        return [AgeCategoryService::class]; 
    }
}
