<?php

namespace Mission4\CinnamonRole;

use Illuminate\Support\ServiceProvider;

class CinnamonRoleServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->loadMigrationsFrom(__DIR__.'/migrations');

        $this->publishes([
            __DIR__.'/js/components' => base_path('resources/assets/js/vendor/cinnamon-role/components'),
        ]);
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
