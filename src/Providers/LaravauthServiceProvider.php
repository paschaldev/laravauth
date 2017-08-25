<?php

namespace PaschalDev\Laravauth\Providers;

use PaschalDev\Laravauth\Laravauth;
use Illuminate\Foundation\AliasLoader;
use Illuminate\Support\ServiceProvider;

class LaravauthServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->laravauthRoutes();
        $this->laravauthPublishes();
        $this->laravauthConfig();
        $this->laravauthViews();
        $this->laravauthMigrations();
        $this->laravauthHelpers();
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        AliasLoader::getInstance()->alias('Laravauth', 
            'PaschalDev\Laravauth\Facades\Laravauth');

        $this->app->bind('laravauth', function()
        {
            return new Laravauth;
        });

        $this->registerNexmo();
        $this->registerTwilio();
    }

    /**
     * Items to be published
     *
     * @return void
     */
    protected function laravauthPublishes(){

        $this->publishes([
            __DIR__.'/../config/laravauth.php' => config_path('laravauth.php'),
            __DIR__.'/../resources/views' => resource_path('views/vendor/laravauth'),
            ]);
    }

    /**
     * Marge the package's configuration.
     *
     * @return void
     */
    protected function laravauthConfig(){

        $this->mergeConfigFrom( __DIR__.'/../config/laravauth.php', 
            'laravauth' );
    }

    /**
     * Include routes.
     *
     * @return void
     */
    protected function laravauthRoutes(){

        // This loads the routes when the app is booted thereby 
        // overriding the initial login routes
        $this->app->booted(function () {

            $this->loadRoutesFrom(__DIR__.'/../routes/web.php');
        });
    }

    /**
     * Load views.
     *
     * @return void
     */
    protected function laravauthViews(){

        $this->loadViewsFrom(__DIR__.'/../resources/views', 
            'laravauth');
    }

    /**
     * Load migrations.
     *
     * @return void
     */
    protected function laravauthMigrations(){

        $this->loadMigrationsFrom(__DIR__.'/../migrations');
    }

    /**
     * Register helpers file
     *
     * @return void
     */
    protected function laravauthHelpers()
    {
        require_once __DIR__.'/../helpers.php';
    }

    /**
     * Register Nexmo (SMS Gateway)
     *
     * @return void
     */
    public function registerNexmo(){

        $this->app->register(
            'Nexmo\Laravel\NexmoServiceProvider'
            );
    }

    /**
     * Register Twilio (SMS Gateway)
     *
     * @return void
     */
    public function registerTwilio(){

        $this->app->register(
            'Aloha\Twilio\Support\Laravel\ServiceProvider'
            );
    }
}
