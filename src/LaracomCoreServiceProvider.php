<?php

namespace Laracommerce\Core;

use Illuminate\Support\ServiceProvider;

class LaracomCoreServiceProvider extends ServiceProvider
{
    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        //$this->mergeConfigFrom($this->configPath(), 'laracomcore');
    }

    /**
     * Perform post-registration booting of services.
     *
     * @return void
     */
    public function boot()
    {
        // Publish migrations
        $migrationPath = __DIR__.'/../database/migrations';
        $this->publishes([$migrationPath => base_path('database/migrations')], 'migrations');
    }

    /**
     * Get the config path
     *
     * @return string
     */
    protected function configPath()
    {
        return __DIR__ . '/../config/laracomcore.php';
    }

    /**
     * Publish the config file
     *
     * @param  string $configPath
     */
    protected function publishConfig($configPath)
    {
        $this->publishes([$configPath => config_path('laracomcore.php')], 'config');
    }

    protected function isLumen()
    {
        return str_contains($this->app->version(), 'Lumen');
    }
}