<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Http\Middleware\RequestResponseLogger;

class RequestResponseLoggerServiceProvider extends ServiceProvider
{
    /**
     * Register bindings in the container.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton(RequestResponseLogger::class, function ($app) {
            return new RequestResponseLogger();
        });
    }
}