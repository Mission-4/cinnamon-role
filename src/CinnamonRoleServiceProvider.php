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
        $this->loadRoutesFrom(__DIR__.'/routes/routes.php');

        $this->loadMigrationsFrom(__DIR__.'/migrations');

        $this->publishes([
            __DIR__.'/js/components' => base_path('resources/js/components/cinnamon-role'),
        ], 'cinnamon-role');

        $this->publishes([
            __DIR__.'/config/cinnamon-role.php' => config_path('cinnamon-role.php'),
        ], 'cinnamon-role');
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
    }
}
