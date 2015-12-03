<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Connectors;

class PrintOutServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton('PrintOut', function(){

            return new \App\Connectors\PrintOut_connector();

        });

    }
    
    
}
