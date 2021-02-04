<?php

namespace Rezahmady\SettingOperation;

use Illuminate\Support\ServiceProvider;

class SettingOperationServiceProvider extends ServiceProvider
{
    /**
     * Perform post-registration booting of services.
     *
     * @return void
     */
    public function boot(): void
    {
        $this->loadTranslationsFrom(__DIR__.'/../resources/lang', 'setting-operation');
        // $this->loadViewsFrom(__DIR__.'/../resources/views', 'rezahmady');
        // $this->loadMigrationsFrom(__DIR__.'/../database/migrations');
        // $this->loadRoutesFrom(__DIR__.'/routes.php');

        // load views
        // - from 'resources/views/vendor/backpack/setting-operation' if they're there
        // - otherwise fall back to package views
        $this->loadViewsFrom(resource_path('views/vendor/backpack/setting-operation'), 'setting-operation');
        $this->loadViewsFrom(__DIR__.'/../resources/views', 'setting-operation');

        // Publishing is only necessary when using the CLI.
        if ($this->app->runningInConsole()) {
            $this->bootForConsole();
        }
    }

    /**
     * Register any package services.
     *
     * @return void
     */
    public function register(): void
    {
        $this->mergeConfigFrom(__DIR__.'/../config/setting-operation.php', 'setting-operation');

        // Register the service the package provides.
        $this->app->singleton('setting', function ($app) {
            return new Setting;
        });
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return ['setting'];
    }

    /**
     * Console-specific booting.
     *
     * @return void
     */
    protected function bootForConsole(): void
    {
        // Publishing the configuration file.
        $this->publishes([
            __DIR__.'/../config/setting-operation.php' => config_path('setting-operation.php'),
        ], 'setting-operation.config');

        // Publishing the views.
        $this->publishes([
            __DIR__.'/../resources/views' => base_path('resources/views/vendor/backpack/setting-operation'),
        ], 'setting-operation.views');

        // publish migrations
        $this->publishes([
            __DIR__.'/database/migrations' => database_path('migrations'),
        ], 'migrations');

        // Publishing the translation files.
        $this->publishes([
            __DIR__.'/../resources/lang' => resource_path('lang/vendor/backpack'),
        ], 'setting-operation.views');
    }
}
