<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Connectors\ESB_connector;

class EsbServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton('ESB_conn', function () {
            return new ESB_connector();
        });
    }
}
