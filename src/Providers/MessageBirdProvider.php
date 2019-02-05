<?php

namespace PaschalDev\Laravauth\Providers;

use Illuminate\Support\ServiceProvider;
use MessageBird\Client;

class MessageBirdProvider extends ServiceProvider
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
        $this->app->bind('messagebird', function () {
            return new Client(env('MESSAGEBIRD_KEY'));
        });
    }
}
