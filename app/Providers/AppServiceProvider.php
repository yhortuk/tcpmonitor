<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Socket\Raw\Factory;
use Socket\Raw\Socket;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton(Socket::class, function () {
            $factory = new Factory();
            return $factory->createClient(config('services.philips.tcp'), 3);
        });
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
