<?php

namespace App\Providers;

use App\Helpers\DbDebugHelper;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        if ($this->app->environment() !== 'production') {
            DbDebugHelper::dbDebug();
        }
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        /* if ($this->app->environment() !== 'production') {
             $this->app->register(\Barryvdh\LaravelIdeHelper\IdeHelperServiceProvider::class);
         }*/
    }
}
